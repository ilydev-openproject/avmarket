<form wire:submit.prevent="updateProfile">
    <div class="tptrack__content grey-bg">
        <div class="tptrack__item d-flex mb-20">
            <div class="tptrack__item-icon">
                <i class="fal fa-user-unlock"></i>
            </div>
            <div class="tptrack__item-content">
                <h4 class="tptrack__item-title">Profil Saya</h4>
                <p>Silahkan lengkapi data anda untuk mempermudah pengisian form pembelian ataupun fitur
                    - fitur yang lain terimakasih.</p>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        <div class="tptrack__id mb-10">
            <div class="form">
                <span><i class="fal fa-user"></i></span>
                <input type="email" wire:model="email" placeholder="Username / email address">
            </div>
        </div>

        <div class="tptrack__email mb-10">
            <div class="form">
                <span><i class="fal fa-key"></i></span>
                <input type="text" wire:model="name" placeholder="Nama">
            </div>
        </div>

        <div class="mb-10">
            <label>Bergabung sejak</label>
            <span>{{ $created_at }}</span>
        </div>

        <div class="container">
                            <!-- @if($error)
                                <div class="alert alert-danger mb-4">{{ $error }}</div>
                            @endif -->

                            <div class="row">
                                <!-- Provinsi -->
                                <div class="col-md-6">
                                    <div class="checkout-form-list mb-3">
                                        <label>Provinsi</label>
                                        <select wire:model.live="selectedProvince" class="form-select"
                                            wire:loading.attr="disabled">
                                            <option value="">-- Pilih Provinsi --</option>
                                            @foreach($provinces as $province)
                                                <option value="{{ $province['id'] }}">{{ $province['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Kabupaten/Kota -->
                                <div class="col-md-6">
                                    <div class="checkout-form-list mb-3">
                                        <label class="d-flex justify-content-between align-items-center">
                                            <span>Kabupaten/Kota</span>
                                            <div wire:loading.flex wire:target="selectedProvince"
                                                class="align-items-center">
                                                <div class="spinner-border spinner-border-sm text-primary"
                                                    role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <small class="text-muted ms-2">Memuat data kota...</small>
                                            </div>
                                        </label>
                                        <select wire:model.live="selectedCity" class="form-select"
                                            @if(!$selectedProvince || $isLoadingCities) disabled @endif
                                            wire:loading.attr="disabled">
                                            <option value="">-- Pilih Kabupaten --</option>
                                            @if($isLoadingCities)
                                                <option value="" disabled>Memuat data kabupaten...</option>
                                            @else
                                                @foreach($cities as $city)
                                                    <option value="{{ $city['id'] }}">{{ $city['name'] }}</option>

                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

        <div class="tptrack__btn">
            <button type="submit" class="tptrack__submition active">Simpan<i
                    class="fal fa-long-arrow-right"></i></button>
        </div>
    </div>
</form>