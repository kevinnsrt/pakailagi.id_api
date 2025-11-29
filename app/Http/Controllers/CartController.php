<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
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
