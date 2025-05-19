<div>
    <style>
        .custom-autocomplete { position: relative; }
        .autocomplete-input { 
            width: 100%; 
            padding: 8px; 
            border: 1px solid #ccc; 
            border-radius: 4px; 
            font-size: 14px; 
        }
        .autocomplete-options { 
            position: absolute; 
            z-index: 1000; 
            width: 100%; 
            max-height: 200px; 
            overflow-y: auto; 
            background: white; 
            border: 1px solid #ccc; 
            border-radius: 4px; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
            margin-top: 2px; 
        }
        .option { 
            padding: 8px; 
            cursor: pointer; 
        }
        .option:hover { 
            background: #f0f0f0; 
        }
        .option-empty { 
            padding: 8px; 
            color: #666; 
            text-align: center; 
        }
        [x-cloak] { display: none; }
    </style>

    <div class="row">
        <!-- Provinsi -->
        <div class="col-md-6">
            <div class="checkout-form-list mb-3">
                <label>Provinsi</label>
                <div class="custom-autocomplete" x-data="{ search: '', open: false }" x-init="search = '{{ $provinceName ?? '' }}'">
                    <input type="text" x-model="search" @input="open = true" @click="open = true"
                        @keydown.esc="open = false" placeholder="Ketik provinsi..."
                        class="autocomplete-input" wire:model.debounce.300ms="selectedProvinceId"
                        wire:loading.attr="disabled">
                    <div class="autocomplete-options" x-show="open" x-cloak x-transition
                        wire:key="province-options">
                        <template x-for="option in $wire.provinces.filter(p => 
                            search ? p.name.toLowerCase().includes(search.toLowerCase()) : true
                        )" :key="option.id">
                            <div class="option" @click="$wire.set('selectedProvinceId', option.id); 
                                search = option.name; open = false" x-text="option.name"></div>
                        </template>
                        <div class="option option-empty" x-show="!$wire.provinces.filter(p => 
                            search ? p.name.toLowerCase().includes(search.toLowerCase()) : true
                        ).length">Tidak ada hasil</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kabupaten/Kota -->
        <div class="col-md-6">
            <div class="checkout-form-list mb-3">
                <label class="d-flex justify-content-between align-items-center">
                    <span>Kabupaten/Kota</span>
                    <div wire:loading.flex wire:target="selectedProvinceId" class="align-items-center">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <small class="text-muted ms-2">Memuat kota...</small>
                    </div>
                </label>
                <div class="custom-autocomplete" x-data="{ search: '', open: false }" x-init="search = '{{ $cityName ?? '' }}'">
                    <input type="text" x-model="search" @input="open = true" @click="open = true"
                        @keydown.esc="open = false" placeholder="Ketik kabupaten/kota..."
                        class="autocomplete-input" wire:model.debounce.300ms="selectedCityId"
                        :disabled="!$wire.selectedProvinceId || $wire.isLoadingCities"
                        wire:loading.attr="disabled">
                    <div class="autocomplete-options" x-show="open" x-cloak x-transition
                        wire:key="city-options-{{ $selectedProvinceId ?: 'empty' }}">
                        <template x-for="option in $wire.cities.filter(c => 
                            search ? c.name.toLowerCase().includes(search.toLowerCase()) : true
                        )" :key="option.id">
                            <div class="option" @click="$wire.set('selectedCityId', option.id); 
                                search = option.name; open = false" x-text="option.name"></div>
                        </template>
                        <div class="option option-empty" x-show="!$wire.cities.filter(c => 
                            search ? c.name.toLowerCase().includes(search.toLowerCase()) : true
                        ).length">Tidak ada hasil</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($error)
        <div class="text-danger mt-1 text-sm">{{ $error }}</div>
    @endif

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        <script>
            document.addEventListener('click', function (event) {
                if (!event.target.closest('.custom-autocomplete')) {
                    document.querySelectorAll('.autocomplete-options').forEach(el => {
                        el.__x.$data.open = false;
                    });
                }
            });
        </script>
    @endpush
</div>