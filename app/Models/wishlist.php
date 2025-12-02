<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class wishlist extends Model
{
    //
    //
    protected $table = 'carts';

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
