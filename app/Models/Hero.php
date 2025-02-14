<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Hero extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class, 'cta');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'cta');
    }

    public function tags()
    {
        return $this->belongsTo(Tags::class, 'cta');
    }
}
