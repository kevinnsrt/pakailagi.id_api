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
    return $this->belongsTo(User::class, 'uid', 'uid');
}

public function product(): BelongsTo
{
    return $this->belongsTo(Product::class, 'product_id', 'id');
}

}
