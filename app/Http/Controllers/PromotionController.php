<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class PromotionController extends Controller
{
    // Menampilkan halaman list promosi & form tambah
    public function index()
    {
        // Ambil data terbaru untuk ditampilkan di list riwayat
        $data = Promotion::latest()->get();
        return view('promosi', compact('data'));
    }

    // Menyimpan promosi baru & MENGIRIM NOTIFIKASI
    public function store(Request $request, FirebaseService $firebase)
    {
        // 1. Validasi Input
        $request->validate([
            'title' => 'required|string|max:255',
            'body'  => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,svg|max:2048', // Max 2MB
        ]);

        // 2. Simpan Gambar
        $path = $request->file('image')->store('promotions', 'public');

        // 3. Simpan ke Database
        $promotion = Promotion::create([
            'title'      => $request->title,
            'body'       => $request->body,
            'image_path' => $path,
        ]);

        // 4. 🔔 KIRIM NOTIFIKASI KE FIREBASE
        // Mengirim notifikasi ke topik 'all_users' (atau sesuaikan dengan topik aplikasi Anda)
        try {
            $firebase->sendToTopic(
                'all_users',                 // Topik
                $promotion->title,           // Judul Notif
                $promotion->body,            // Isi Notif
                url('storage/' . $path)      // Gambar Full URL (HTTPS)
            );
        } catch (\Exception $e) {
            // Opsional: Log error jika firebase gagal, tapi jangan hentikan flow
            \Log::error('Firebase Error: ' . $e->getMessage());
        }

        return redirect()->route('promosi.index')->with('success', 'Promosi berhasil dibuat dan notifikasi dikirim!');
    }

    // Menghapus promosi
    public function destroy($id)
    {
        $promotion = Promotion::findOrFail($id);

        // 1. Hapus gambar dari storage
        if ($promotion->image_path && Storage::disk('public')->exists($promotion->image_path)) {
            Storage::disk('public')->delete($promotion->image_path);
        }

        // 2. Hapus dari database
        $promotion->delete();

        return redirect()->route('promosi.index')->with('success', 'Promosi berhasil dihapus!');
    }

    public function resend($id, FirebaseService $firebase)
    {
        $promotion = Promotion::findOrFail($id);

        try {
            $firebase->sendToTopic(
                'all_users',                 
                $promotion->title,           
                $promotion->body,            
                url('storage/' . $promotion->image_path)      
            );
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim notifikasi: ' . $e->getMessage());
        }

        return back()->with('success', 'Notifikasi berhasil dikirim ulang! 🚀');
    }

    public function show(){
        $data = Promotion::latest()->get();
        return response()->json($data);
    }
}