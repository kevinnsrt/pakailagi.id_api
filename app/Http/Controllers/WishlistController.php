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
    {

        $request->validate([
            'uid' => 'required|string',
        ]);
        $data = Wishlist::with('product')
            ->where('uid', $request->uid)
            ->get()
            ->map(function ($wishlist) {
                if ($wishlist->product && $wishlist->product->image_path) {
                    $wishlist->product->image_path = URL::to('/storage/' . $wishlist->product->image_path);
                }
                return $wishlist;
            });

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wishlist $wishlist)
    {
        //
    }

    /**
     * Remove specific wishlist item.
     */
    public function destroy($id)
    {
        $wishlist = Wishlist::find($id);

        if (! $wishlist) {
            return response()->json([
                'status'  => 'failed',
                'message' => 'Data wishlist tidak ditemukan',
            ], 404);
        }

        $wishlist->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Produk dihapus dari wishlist',
        ]);
    }
}
