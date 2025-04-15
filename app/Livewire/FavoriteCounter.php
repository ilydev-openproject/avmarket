<?php

namespace App\Livewire;

use Livewire\Component;

class FavoriteCounter extends Component
{
    public $count = 0;

    protected $listeners = ['favorite-updated' => 'updateCount'];

    public function mount()
    {
        $this->updateCount();
    }

    public function updateCount()
    {
        $favorite = session('favorite', []);
        $this->count = count($favorite);
    }

    public function render()
    {
        return view('livewire.favorite-counter');
    }
}
