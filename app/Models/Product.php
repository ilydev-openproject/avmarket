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

    protected $fillable = [
        'nama_product',
        'slug',
        'brand',
        'bpom',
        'harga',
        'stok',
        'terjual',
        'diskon',
        'foto_product',
        'id_kategori',
        'deskripsi',
        'ringkasan',
        'keyword',
        'label',
    ];
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
}
