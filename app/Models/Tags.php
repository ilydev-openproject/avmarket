<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tags extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_tag',
        'slug',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_tag', 'id_tag', 'id_product');
    }
}
