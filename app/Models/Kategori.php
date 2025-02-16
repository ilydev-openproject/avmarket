<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Kategori extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    protected $fillable = [
        'nama_kategori',
        'slug'
    ];

    public function Product()
    {
        return $this->hasMany(Product::class, 'id_kategori');
    }

    public function hero()
    {
        return $this->hasMany(Hero::class);
    }
}
