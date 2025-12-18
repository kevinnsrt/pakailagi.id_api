<?php

namespace App\Models;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    //
    protected $table = 'products';

    protected $fillable = [
        'name',
        'deskripsi',
        'price',
        'kondisi',
        'ukuran',
        'image_path',
        'status',
        'kategori'
    ];

    public function carts()
{
    return $this->hasMany(Product::class);
}

    public function wishlist()
{
    return $this->hasMany(Product::class);
}
    
}
