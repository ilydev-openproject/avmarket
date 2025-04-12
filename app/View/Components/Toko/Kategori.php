<?php

namespace App\View\Components\Toko;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Kategori extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public $kategoris)
    {
        $this->kategoris = $kategoris;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.toko.kategori');
    }
}
