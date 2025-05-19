<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\Tags;
use Livewire\Component;
use App\Models\Kategori;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class BlogIndex extends Component
{
    use WithPagination;
    public $kategori;
    public $tag;
    public $search = '';
    protected $queryString = ['search', 'kategori', 'tag'];
    public $kategoriSlug;
    public $tagSlug;

    public function mount($kategoriSlug = null, $tagSlug = null)
    {
        $this->kategori = $kategoriSlug;
        $this->tag = $tagSlug;
    }

    public function render()
    {
        $query = Post::query()
            ->with(['kategori', 'tags'])
            ->where('is_published', true);


        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->kategori) {
            $kategori = Kategori::where('slug', $this->kategori)->first();
            if ($kategori) {
                $query->where('kategori_id', $kategori->id_kategori);
            }
        }

        if ($this->tag) {
            $tag = Tags::where('slug', $this->tag)->first();
            if ($tag) {
                $query->whereHas('tags', function ($q) use ($tag) {
                    $q->where('tags.id', $tag->id);
                });
            }
        }


        $posts = $query->latest()->paginate(8);

        $kategoris = Kategori::all()->map(function ($kategori) {
            return [
                'id' => $kategori->id_kategori,
                'slug' => $kategori->slug,
                'nama' => $kategori->nama_kategori,
                'count' => Post::where('kategori_id', $kategori->id_kategori)->where('is_published', true)->count(),
            ];
        });


        $recentPosts = Post::where('is_published', true)
            ->latest()
            ->take(5)
            ->get();

        $tags = Tags::all()->pluck('nama_tag', 'id');


        return view('livewire.blog-index', compact('posts', 'kategoris', 'recentPosts', 'tags'));
    }

    public function updated($property)
    {
        $this->resetPage();
    }
}
