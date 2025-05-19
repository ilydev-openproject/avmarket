<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Profile extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $photo;
    public $error;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'photo' => 'nullable|image|max:2048',
    ];

    public function mount()
    {
        if (!Auth::check()) {
            Log::warning('No authenticated user found in Profile component');
            return redirect()->route('login');
        }

        $user = Auth::user();
        if (!$user) {
            Log::error('Authenticated user object is null');
            return redirect()->route('login');
        }

        $this->name = $user->name;
        $this->email = $user->email;
        $this->rules['email'] = 'required|email|max:255|unique:users,email,' . ($user->id_user ?? 0) . ',id_user';

        Log::info('Profile Component Mounted', ['user_id' => $user->id_user ?? 'null', 'email' => $user->email]);
    }

    public function updateProfile()
    {
        $this->validate();

        try {
            $user = Auth::user();
            if (!$user) {
                throw new \Exception('No authenticated user found');
            }

            $user->update([
                'name' => $this->name,
                'email' => $this->email,
            ]);

            if ($this->photo) {
                $user->clearMediaCollection('profile_photo');
                $user->addMedia($this->photo->getRealPath())
                    ->toMediaCollection('profile_photo');
            }

            Log::info('Profile updated', ['user_id' => $user->id_user]);
            session()->flash('message', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Profile update failed', ['error' => $e->getMessage()]);
            $this->error = 'Gagal memperbarui profil. Silakan coba lagi.';
        }
    }
    public function render()
    {
        Log::info('Rendering Profile Component', ['name' => $this->name, 'email' => $this->email]);
        return view('livewire.profile');
    }
}