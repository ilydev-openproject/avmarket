<div>
    <form wire:submit.prevent="updateProfile">
        <div class="tptrack__content grey-bg">
            <div class="tptrack__item d-flex mb-20">
                <div class="tptrack__item-icon">
                    <i class="fal fa-user-unlock"></i>
                </div>
                <div class="tptrack__item-content">
                    <h4 class="tptrack__item-title">Profil Saya</h4>
                    <p>Silahkan lengkapi data anda untuk mempermudah pengisian form pembelian ataupun fitur lain. Terima
                        kasih.</p>
                </div>
            </div>

            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            @if ($error)
                <div class="alert alert-danger mb-4">{{ $error }}</div>
            @endif
            <div class="d-flex justify-content-between align-items-center mb-10 p-3 w-100"
                style="background-color: #fff; border-radius: 12px;">
                <!-- Tampilkan Foto Profil -->
                <div class="tptrack__photo d-flex justify-content-center align-items-center m-0"
                    style="width: 80px; height: 80px;">
                    <div class="form m-0">
                        @if (Auth::user()->getFirstMediaUrl('profile_photo'))
                            <div class="postbox__comment-avater">
                                <img src="{{ Auth::user()->getFirstMediaUrl('profile_photo', 'thumb') }}" alt="Foto Profil"
                                    style="max-width: 100px; max-height: 100px;">
                            </div>
                        @else
                            <p>Belum ada foto profil.</p>
                        @endif
                    </div>
                </div>

                <!-- Input Upload Foto -->
                <div class="tptrack__photo-upload w-100 ms-3">
                    @error('photo') <span class="text-danger">{{ $message }}</span> @enderror
                    <div class="form px-4 d-flex justify-content-center align-items-center mb-10"
                        style="background-color: #dedede; border-radius: 18px;">
                        <input type="file" id="uploadfoto" hidden wire:model="photo" style="cursor: pointer;" />
                        <label for="uploadfoto" style="cursor: pointer;width: 100%;">Ganti Foto</label>
                        <span class="p-2"><i class="fal fa-upload"></i></span>
                    </div>
                    <span x-for="uploadfoto" id="file-chosen" class="m-2">No file chosen</span>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const uploadFoto = document.getElementById('uploadfoto');
                        const fileChosen = document.getElementById('file-chosen');

                        if (uploadFoto && fileChosen) {
                            uploadFoto.addEventListener('change', function () {
                                fileChosen.textContent = this.files.length > 0 ? this.files[0].name : 'No file chosen';
                            });
                        } else {
                            console.error('Element uploadfoto or file-chosen not found');
                        }
                    });
                </script>
            </div>

            <div class="tptrack__id mb-10">
                <div class="form">
                    <span><i class="fal fa-user"></i></span>
                    <input type="email" wire:model="email" placeholder="Email address">
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="tptrack__email mb-10">
                <div class="form">
                    <span><i class="fal fa-key"></i></span>
                    <input type="text" wire:model="name" placeholder="Nama">
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="tptrack__btn">
                <button type="submit" class="tptrack__submition active">Simpan<i
                        class="fal fa-long-arrow-right"></i></button>
            </div>
        </div>
    </form>
</div>