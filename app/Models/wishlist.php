<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wishlist extends Model
{
    protected $table = 'wishlists';   // <-- tabel yang benar

    protected $fillable = [
        'uid',
        'product_id',
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
