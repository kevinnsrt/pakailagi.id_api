<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\URL;

class CartController extends Controller
{

    // status pesanan -> proses
    public function proses(Request $request){

        $request->validate([
            'id' => 'required|array',
            'id*' => 'integer'
        ]);

        $selectedId = $request->id;

        $data = Cart::whereIn('id',$selectedId)->update([
            'status'=> 'Diproses'
        ]);

        return response()->json([
            'message'=> 'Barang berhasil di checkout'
        ]);
    }

    // tambah barang ke keranjang
    public function store(Request $request)
    {

        $uid = $request->attributes->get('firebase_uid');

        $request->validate([
            'uid' => 'required|string',
            'product_id'=>'required|string',
        ]);

        $exists = Cart::where('uid',$uid)
        ->where('product_id',$request->product_id)
        ->exists();

        if($exists){
            return response()->json([
                'message'=> 'barang sudah ada di produk'
            ]);
        }

        $data = Cart::create([
            'uid' => (string) $uid,
            'product_id'=>$request->product_id,
            'status'=> 'Dikeranjang'
        ]);

        return response()->json([
            'status'=>'success',
            'message'=> 'Barang berhasil ditambahkan ke keranjang'
        ]);
    }

    // menampilkan barang yang dikeranjang
    public function show(Request $request)
    {
        $uid = $request->attributes->get('firebase_uid');

        $data = Cart::with('product')
            ->where('uid', $uid)
            // ->where('status','Dikeranjang')
            ->get()
            ->map(function($cart) {
                if ($cart->product && $cart->product->image_path) {
                    $cart->product->image_path = URL::to('/storage/' . $cart->product->image_path);
                }
                return $cart;
            });

        return response()->json($data);
    }


    // dashboard history admin web
    public function historyAdmin()
    {
        $data = Cart::with(['user', 'product'])->latest()->get();

        return view('history', compact('data'));
    }

    // status pesanan ->  Dalam Pengiriman
public function prosesPesanan($id, FirebaseService $firebase)
{
    // Ambil cart + relasi product
    $cart = Cart::with('product')->findOrFail($id);

    // Update status
    $cart->update([
        'status' => 'Dalam Pengiriman'
    ]);

    // Ambil user
    $user = User::find($cart->uid);

    // Kirim notif jika ada token
    if ($user && $user->fcm_token) {
        $firebase->sendToToken(
            $user->fcm_token,
            'Pesanan Diproses 🚚',
            $cart->product->name . ' sedang dikirim',
            null
        );
    }

    return redirect()->route('history.admin');
}

    // status pesanan -> Dibatalkan
public function batalPesanan($id){
    // 1. Ambil datanya dulu
    $cart = Cart::find($id);

    if (!$cart) {
        return redirect()->back()->with('error', 'Data tidak ditemukan');
    }

    $cart->update([
        'status' => 'Dibatalkan'
    ]);

    $user = User::find($cart->uid);

    if ($user && $user->fcm_token) {

        $productName = $cart->product ? $cart->product->name : 'Item';

        $firebase->sendToToken(
            $user->fcm_token,
            'Pesanan Anda Dibatalkan 😔',
            $productName . ' dibatalkan',
            null
        );
    }

    return redirect(route('history.admin'));
}

    // status pesanan -> Selesai
public function selesai(Request $request)
{
    $request->validate([
        'id' => 'required|array',
        'id.*' => 'integer'
    ]);

    $selectedId = $request->id;

    // Ambil cart yang dipilih
    $carts = Cart::whereIn('id', $selectedId)->get();

    // Update status cart
    Cart::whereIn('id', $selectedId)->update([
        'status' => 'Selesai'
    ]);

    // Ambil product_id dari cart
    $productIds = $carts->pluck('product_id')->unique();

    // Update status product jadi Sold Out
    Product::whereIn('id', $productIds)->update([
        'status' => 'Sold Out'
    ]);

    return response()->json([
        'message' => 'Terimakasih telah berbelanja'
    ]);
}


    // menghapus barang dari keranjang
    public function destroy(Request $request, $id)
    {
        $uid = $request->attributes->get('firebase_uid');

        $wishlist = Cart::where('id', $id)
            ->where('uid', $uid)
            ->first();

        if (! $wishlist) {
            return response()->json([
                'status'  => 'failed',
                'message' => 'Cart tidak ditemukan',
            ], 404);
        }

        $wishlist->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Produk dihapus dari keranjang',
        ]);
    }
}
