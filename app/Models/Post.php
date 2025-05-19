<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $guarded = [];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id_kategori');
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tags::class,
            'post_tags',
            'post_id',
            'tag_id'
        );
    }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('post_image')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif']);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        ini_set('memory_limit', '512M');
        try {
            $this->addMediaConversion('webp')
                ->format('webp')
                ->quality(80)
                ->width(1200)
                ->height(800)
                ->performOnCollections('post_image')
                ->queued();
            $this->addMediaConversion('avif')
                ->format('avif')
                ->quality(80)
                ->width(1200)
                ->height(800)
                ->performOnCollections('post_image')
                ->queued();
        } catch (\Exception $e) {
            Log::error('Gagal konversi gambar (WebP/AVIF): ' . $e->getMessage() . ' | File: ' . ($media ? $media->file_name : 'unknown') . ' | Trace: ' . $e->getTraceAsString());
        }
    }

}
