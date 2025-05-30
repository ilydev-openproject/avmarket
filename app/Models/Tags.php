<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tags extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_tag', 'id_tag', 'id_product');
    }

    public function hero()
    {
        return $this->hasMany(Hero::class);
    }

    public function posts()
    {
        return $this->belongsToMany(
            Post::class,
            'post_tags',
            'tag_id',
            'post_id'
        );
    }
}
