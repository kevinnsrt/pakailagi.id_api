<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function proses(Request $request){

        $request->validate([
            'id' => 'required|array'
        ]);

        $selectedId = $request->id;
        $data = Cart::whereIn('id',$selectedId)->get();

        $data->update([
            'status'=> 'Diproses'
        ]);

        return response()->json([
            'message'=> 'Barang berhasil di checkout'
        ]);


    }

    /**
     * Store a newly created resource in storage.
     */
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

    public function show(Request $request)
    {
        $data = Cart::with('product')
            ->where('uid', $request->uid)
            ->get()
            ->map(function($cart) {
                if ($cart->product && $cart->product->image_path) {
                    $cart->product->image_path = URL::to('/storage/' . $cart->product->image_path);
                }
                return $cart;
            });

        return response()->json($data);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
