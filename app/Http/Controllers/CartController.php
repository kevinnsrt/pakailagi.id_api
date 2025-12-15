<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
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
        $request->validate([
            'uid' => 'required|string',
            'product_id'=>'required|string',
        ]);

        $exists = Cart::where('uid',$request->uid)
        ->where('product_id',$request->product_id)
        ->exists();

        if($exists){
            return response()->json([
                'message'=> 'barang sudah ada di produk'
            ]);
        }

        $data = Cart::create([
            'uid' => (string) $request->uid,
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
        $data = Cart::with('product')
            ->where('uid', $request->uid)
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
        $data = Cart::with(['user', 'product'])->get();

        return view('history', compact('data'));
    }

    // status pesanan ->  Dalam Pengiriman
    public function prosesPesanan($id){
        $data = Cart::find($id)->update([
            'status' => 'Dalam Pengiriman'
        ]);

        return redirect(route('history.admin'));
    }

    // status pesanan -> Dibatalkan
    public function batalPesanan($id){
        $data = Cart::find($id)->update([
            'status' => 'Dibatalkan'
        ]);

        return redirect(route('history.admin'));
    }

    // status pesanan -> Selesai
    public function selesai(Request $request){

        $request->validate([
            'id' => 'required|array',
            'id*' => 'integer'
        ]);

        $selectedId = $request->id;

        $data = Cart::whereIn('id',$selectedId)->update([
            'status'=> 'Selesai'
        ]);

        return response()->json([
            'message'=> 'Terimakasih telah berbelanja'
        ]);
    }

    // menghapus barang dari keranjang
    public function destroy(Request $request)
    {
        $data = Cart::where('id', $request->id)->delete();
        return response()->json([
            'message' => 'Barang berhasil dihapus dari keranjang'
        ]);
    }
}
