<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    protected $table = 'carts';

    protected $fillable = [
        'uid',
        'product_id',
        'status'
    ];

     public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

     public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function cartToUsers()
    {
        return $this->hasMany(User::class);
    }

    public function cartToProducts()
{
    return $this->hasMany(Apply::class);
}
}
