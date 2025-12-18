<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{

    // menampilkan semua barang pada produk
    public function index(Request $request)
    {
        $data = Product::latest()->get()->map(function ($product) {
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
            'name'      => 'required|string',
            'deskripsi' => 'required|string',
            'kondisi'   => 'required|string',
            'ukuran'    => 'required|string',
            'kategori'  => 'required|string',
            'price'     => 'required|integer',
            'image'     => 'required|image|mimes:jpg,jpeg,png,svg',
        ]);

        // simpan gambar
        $path = $request->file('image')->store('products', 'public');

        // simpan produk
        $product = Product::create([
            'name'       => $request->name,
            'price'      => $request->price,
            'deskripsi'  => $request->deskripsi,
            'kondisi'    => $request->kondisi,
            'kategori'   => $request->kategori,
            'ukuran'     => $request->ukuran,
            'image_path' => $path,
            'status'     => 'Ready',
        ]);

        // 🔔 KIRIM NOTIFIKASI KE FIREBASE
        $firebase->sendToTopic(
            'all_users',
            'Produk Baru Tersedia 🔥',
            $product->name . ' - Rp ' . number_format($product->price, 0, ',', '.'),
            url('storage/' . $path) // HTTPS
        );

        return redirect()->route('barang')->with('success', 'Barang berhasil di upload!');
    }

    // menampilkan detail produk
    public function details(Request $request)
    {

        $product = Product::findOrFail($request->id);

        $product->image_path = URL::to('/storage/' . $product->image_path);

        if ($product == null) {
            return response()->json([
                'message' => 'produk tidak ditemukan',
            ]);
        }

        return response()->json([$product]);
    }

    public function tambah_barang()
    {
        return view('tambah-barang');
    }

    // menampilkan list produk pada web admin
    public function show()
    {
        //
        $data = Product::latest()->get();

        return view('content', compact('data'));
    }

    // update barang dari admin
    public function update(Request $request, $id)
    {
        // 1. Validasi input
        $request->validate([
            'name'      => 'required|string',
            'deskripsi' => 'required|string',
            'kondisi'   => 'required|string',
            'ukuran'    => 'required|string',
            'kategori'  => 'required|string',
            'price'     => 'required|integer',
            // Image bersifat nullable (tidak wajib diisi saat edit)
            'image'     => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048', 
        ]);

        // 2. Cari produk berdasarkan ID
        $product = Product::findOrFail($id);

        if (in_array($product->status, ['Sold Out', 'Diproses'])) {
            return redirect()->back()->with('error', 'Barang yang sudah terjual atau sedang diproses tidak dapat diedit!');
        }

        // 3. Siapkan data yang akan diupdate
        $data = [
            'name'      => $request->name,
            'price'     => $request->price,
            'deskripsi' => $request->deskripsi,
            'kondisi'   => $request->kondisi,
            'kategori'  => $request->kategori,
            'ukuran'    => $request->ukuran,
        ];

        // 4. Cek apakah user mengupload gambar baru
        if ($request->hasFile('image')) {
            
            // Hapus gambar lama jika ada di storage
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }

            // Simpan gambar baru
            $path = $request->file('image')->store('products', 'public');
            
            // Masukkan path baru ke array data
            $data['image_path'] = $path;
        }

        // 5. Update database
        $product->update($data);

        // 6. Redirect kembali ke halaman barang
        return redirect()->route('barang')->with('success', 'Barang berhasil diperbarui!');
    
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

    public function search(Request $request)
    {
        $request->validate([
            'keyword' => 'required|string|min:2',
        ]);

        $data = Product::where('name', 'LIKE', '%' . $request->keyword . '%')
            ->get()
            ->map(function ($product) {
                $product->image_path = URL::to('/storage/' . $product->image_path);
                return $product;
            });

        return response()->json(
            $data,
        );
    }

    // menghapus barang dari web admin
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // 1. Hapus gambar dari storage jika ada
        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }

        // 2. Hapus data dari database
        $product->delete();

        // 3. Redirect kembali dengan pesan sukses
        return redirect()->route('barang')->with('success', 'Barang berhasil dihapus!');
    }
}
