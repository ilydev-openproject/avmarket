<?php
namespace App\Livewire;

use App\Models\UserCart;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

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
        // Jika pengguna tidak login, ambil keranjang dari session
        if (Auth::check()) {
            // Ambil jumlah keranjang dari tabel user_carts
            $this->count = UserCart::where('id_user', Auth::id())->sum('quantity');
        } else {
            // Ambil jumlah keranjang dari session untuk pengguna yang tidak login
            $cart = session('cart', []);
            $this->count = collect($cart)->sum('quantity');
        }
    }

    public function render()
    {
        return view('livewire.cart-counter');
    }
}
