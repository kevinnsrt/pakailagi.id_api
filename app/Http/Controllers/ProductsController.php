<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class ProductsController extends Controller
{

    // menampilkan semua barang pada produk
    public function index(Request $request)
    {
        $data = Product::all()->map(function($product) {
            // Mengubah image_path menjadi full URL
            $product->image_path = URL::to('/storage/' . $product->image_path);
            return $product;
        });

        return response()->json($data);
    }


    // menambahkan barang dari web admin 


public function store(Request $request, FirebaseService $firebase)
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

    // simpan gambar
    $path = $request->file('image')->store('products', 'public');

    // simpan produk
    $product = Product::create([
        'name' => $request->name,
        'price'=> $request->price,
        'deskripsi'=> $request->deskripsi,
        'kondisi'=> $request->kondisi,
        'kategori'=> $request->kategori,
        'ukuran'=> $request->ukuran,
        'image_path'=> $path,
        'status' => 'Ready'
    ]);

    // 🔔 KIRIM NOTIFIKASI KE FIREBASE
    $firebase->sendToTopic(
    'all_users',
    'Produk Baru Tersedia 🔥',
    $product->name . ' - Rp ' . number_format($product->price, 0, ',', '.'),
    url('storage/' . $path) // HTTPS
);


    return view('dashboard');
}


    // menampilkan detail produk 
    public function details(Request $request){

        $product = Product::findOrFail($request->id);

        $product->image_path = URL::to('/storage/' . $product->image_path);


        if($product == null){
            return response()->json([
                'message' => 'produk tidak ditemukan',
            ]);
        }   

        return response()->json([$product]);
    }


    public function tambah_barang (){
        return view ('tambah-barang');
    }

    // menampilkan list produk pada web admin
    public function show()
    {
        //
        $data = Product::all();

         return view('content', compact('data'));
    }

    // update barang dari admin
    public function update(Request $request, Product $product)
    {
        //
    }

    // menampilkan barang berdasarkan kategori
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


    // menghapus barang dari web admin
    public function destroy(Product $product)
    {
        //
    }
}
