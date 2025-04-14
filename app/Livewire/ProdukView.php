<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Models\Kategori;
use Livewire\WithPagination;

class ProdukView extends Component
{
    use WithPagination;

    public $viewType = 'list';
    public $sort = 'default';

    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['sort'];
    public function setSort($value)
    {
        $this->sort = $value;
        $this->resetPage(); // supaya pagination balik ke halaman 1
    }
    public function updatingSort()
    {
        $this->resetPage();
    }

    public function render()
    {
        $products = Product::query();

        if ($this->sort === 'termurah') {
            $products = $products->orderBy('harga', 'asc');
        } elseif ($this->sort === 'terlaris') {
            $products = $products->orderBy('terjual', 'desc');
        } else {
            $products = $products->latest();
        }

        return view('livewire.produk-view', [
            'products' => $products->paginate(10),
        ]);
    }
}
