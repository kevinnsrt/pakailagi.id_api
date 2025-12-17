<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. STATISTIK UTAMA
        $totalProduk = Product::count();
        $totalUser = User::count(); 

        $pendapatan = Cart::where('status', 'Selesai')
            ->with('product')
            ->get()
            ->sum(function($cart) {
                return $cart->product->price ?? 0;
            });

        $pesananAktif = Cart::whereIn('status', ['Diproses', 'Dalam Pengiriman'])->count();

        // 2. DATA UNTUK GRAFIK STATUS
        $statusCounts = Cart::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->all();

        $chartStatusLabel = ['Dikeranjang', 'Diproses', 'Dalam Pengiriman', 'Selesai', 'Dibatalkan'];
        $chartStatusData = [
            $statusCounts['Dikeranjang'] ?? 0,
            $statusCounts['Diproses'] ?? 0,
            $statusCounts['Dalam Pengiriman'] ?? 0,
            $statusCounts['Selesai'] ?? 0,
            $statusCounts['Dibatalkan'] ?? 0,
        ];

        // 3. DATA GRAFIK KATEGORI
        $kategoriData = Cart::where('carts.status', 'Selesai')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->select('products.kategori', DB::raw('count(*) as total'))
            ->groupBy('products.kategori')
            ->get();

        $chartKategoriLabel = $kategoriData->pluck('kategori');
        $chartKategoriData = $kategoriData->pluck('total');

        // 4. RECENT ORDERS
        $latestOrders = Cart::with(['user', 'product'])
            ->where('status', '!=', 'Dikeranjang')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalProduk', 
            'totalUser', 
            'pendapatan', 
            'pesananAktif',
            'chartStatusLabel',
            'chartStatusData',
            'chartKategoriLabel',
            'chartKategoriData',
            'latestOrders'
        ));
    }
}