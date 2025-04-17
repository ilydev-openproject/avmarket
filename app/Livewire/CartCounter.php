<?php

namespace App\Livewire;

use Livewire\Component;

class CartCounter extends Component
{
    public $count = 0;

    protected $listeners = ['cart-updated' => 'updateCount'];

    public function mount()
    {
        $this->updateCount();
    }

    public function updateCount()
    {
        $cart = session('cart', []);
        $this->count = collect($cart)->sum('quantity');
    }

    public function render()
    {
        return view('livewire.cart-counter');
    }
}
