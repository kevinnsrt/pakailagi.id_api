<?php
namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class WishlistController extends Controller
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
    // UID dari Firebase Middleware
    $uid = $request->attributes->get('firebase_uid');

    if (!$uid) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $request->validate([
        'product_id' => 'required|',
    ]);

    $exists = Wishlist::where('uid', $uid)
        ->where('product_id', $request->product_id)
        ->exists();

    if ($exists) {
        return response()->json([
            'status'  => 'gagal',
            'message' => 'Produk sudah ada di wishlist',
        ], 409);
    }

    Wishlist::create([
        'uid'        => $uid,
        'product_id' => $request->product_id,
    ]);

    return response()->json([
        'status'  => 'success',
        'message' => 'Produk berhasil ditambahkan ke wishlist',
    ]);
}


    /**
     * Show wishlist daftar produk milik user.
     */
    public function show(Request $request)
    { $uid = $request->attributes->get('firebase_uid');

        $data = Wishlist::with('product')
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

// hapus wishlist
public function destroy(Request $request)
{
    $uid = $request->attributes->get('firebase_uid');

    $wishlist = Wishlist::where('id', $request->id)
        ->where('uid', $uid)
        ->first();

    if (! $wishlist) {
        return response()->json([
            'status'  => 'failed',
            'message' => 'Wishlist tidak ditemukan',
        ], 404);
    }

    $wishlist->delete();

    return response()->json([
        'status'  => 'success',
        'message' => 'Produk dihapus dari wishlist',
    ]);
}

}
