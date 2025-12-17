<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name',
        'deskripsi',
        'price',
        'kondisi',
        'ukuran',
        'image_path',
        'kategori',
        'status' // Tambahkan status jika ada di database
    ];

    public function getImagePathAttribute($value)
    {
        if (str_contains($value, '/storage/https://')) {
            // Ambil bagian URL terakhir setelah kata '/storage/'
            return explode('/storage/', $value)[2] ?? explode('/storage/', $value)[1];
        }
        
        return filter_var($value, FILTER_VALIDATE_URL) ? $value : asset('storage/' . $value);
    }

    // Perbaikan Relasi: Product HAS MANY Cart (Bukan Product::class)
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class, 'product_id');
    }

    public function wishlist(): HasMany
    {
        return $this->hasMany(Wishlist::class, 'product_id');
    }
}