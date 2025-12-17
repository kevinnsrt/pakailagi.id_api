<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UpdateController extends Controller
{
    // Update barang dari admin
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'      => 'required|string',
            'deskripsi' => 'required|string',
            'kondisi'   => 'required|string',
            'ukuran'    => 'required|string',
            'kategori'  => 'required|string',
            'price'     => 'required|integer',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048', // Image nullable (opsional) saat edit
        ]);

        $product = Product::findOrFail($id);

        $data = [
            'name'      => $request->name,
            'price'     => $request->price,
            'deskripsi' => $request->deskripsi,
            'kondisi'   => $request->kondisi,
            'kategori'  => $request->kategori,
            'ukuran'    => $request->ukuran,
        ];

        // Cek jika ada upload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada (opsional, tapi disarankan)
            if ($product->image_path && \Storage::disk('public')->exists($product->image_path)) {
                \Storage::disk('public')->delete($product->image_path);
            }
            
            // Simpan gambar baru
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('barang')->with('success', 'Barang berhasil diperbarui!');
    }
}
