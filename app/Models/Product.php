<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'kategori'
    ];
}
