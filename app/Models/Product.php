<?php

namespace App\Models;

use App\Models\Tag;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $casts = [
        'foto_product' => 'array',
    ];

    protected $guarded = [];
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function tags()
    {
        return $this->belongsToMany(Tags::class, 'product_tag', 'id_product', 'id_tag');
    }

    public function hero()
    {
        return $this->hasMany(Hero::class);
    }

    public function user_cart()
    {
        return $this->hasMany(UserCart::class, 'id_product');
    }
    public function order_item()
    {
        return $this->hasMany(OrderItem::class, 'product_id', 'id_product');
    }
}
