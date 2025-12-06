<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
    use Illuminate\Support\Facades\URL;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index(Request $request)
    {

        // $token = $request->bearerToken();

        // if (!$token) {
        //     return response()->json(['error' => 'No token provided'], 401);
        // }

        // $auth = app('firebase.auth');
        // $verified = $auth->verifyIdToken($token);

        // $userData = $verified->claims();

        $data = Product::all()->map(function($product) {
            // Mengubah image_path menjadi full URL
            $product->image_path = URL::to('/storage/' . $product->image_path);
            return $product;
        });

        return response()->json($data);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{

    $request->validate([
        'name'=> 'required|string',
        'deskripsi'=>'required|string',
        'kondisi'=>'required|string',
        'ukuran'=>'required|string',
        'kategori'=>'required|string',
        'price' => 'required|integer',
        'image' => 'required|image|mimes:jpg,jpeg,png,svg'
    ]);

    $path = $request->file('image')->store('products', 'public');

    $data = Product::create([
        'name' => $request->name,   
        'price'=> $request->price,
        'deskripsi'=> $request->deskripsi,
        'kondisi'=> $request->kondisi,
        'kategori'=> $request->kategori,
        'ukuran'=> $request->ukuran,
        'image_path'=> $path // sudah benar
    ]);

    return view('dashboard');
}

    public function details(Request $request){

        $product = Product::findOrFail($request->id);

        $product->image_path = URL::to('/storage/' . $product->image_path);


        if($data == null){
            return response()->json([
                'message' == 'produk tidak ditemukan',
            ]);
        }   

        return response()->json($product);
    }


    public function tambah_barang (){
        return view ('tambah-barang');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
        $data = Product::all();
         return view('content', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    public function filter(Request $request)
{
     

    $data = Product::where('kategori', $request->kategori)
        ->get() 
        ->map(function ($product) {
            // Mengubah image_path menjadi full URL
            $product->image_path = URL::to('/storage/' . $product->image_path);
            return $product;
        });

    return response()->json($data);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
