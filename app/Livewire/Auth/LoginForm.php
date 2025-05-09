<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginForm extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    public function login()
    {
        $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $this->email)->first();

        if (!$user) {
            $this->addError('email', 'Email belum terdaftar.');
            return;
        }

        if (!Hash::check($this->password, $user->password)) {
            $this->addError('password', 'Password salah.');
            return;
        }

        Auth::login($user, $this->remember);
        session()->regenerate();

        return redirect()->intended('/checkout');
    }
    public function render()
    {
        return view('livewire.auth.login-form');
    }
}
