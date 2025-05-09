<x-app>
    <!-- resources/views/livewire/profil.blade.php -->
    <div class="container py-5">
        <h2 class="mb-4">Profil Saya</h2>

        @if (session()->has('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        <form wire:submit.prevent="updateProfile">
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" wire:model="name" class="form-control">
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" wire:model="email" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</x-app>