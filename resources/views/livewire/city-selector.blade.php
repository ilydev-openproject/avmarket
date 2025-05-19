<div class="custom-autocomplete" x-data="{ search: '', open: false }" x-init="search = '{{ $cityName ?? '' }}'">
    <input type="text" x-model="search" @input="open = true" @click="open = true" @keydown.esc="open = false"
        placeholder="Ketik kabupaten/kota..." class="autocomplete-input" wire:model.debounce.500ms="selectedId"
        :disabled="!$wire . provinceId || $wire . isLoading" wire:loading.attr="disabled">
    <div class="autocomplete-options" x-show="open" x-cloak x-transition
        wire:key="city-options-{{ $provinceId ?: 'empty' }}">
        <template x-for="option in $wire.cities.filter(c => 
            search ? c.name.toLowerCase().includes(search.toLowerCase()) : true
        )" :key="option . id">
            <div class="option" @click="$wire.set('selectedId', option.id); 
                search = option.name; open = false" x-text="option.name"></div>
        </template>
        <div class="option option-empty" x-show="!$wire.cities.filter(c => 
            search ? c.name.toLowerCase().includes(search.toLowerCase()) : true
        ).length">Tidak ada hasil</div>
    </div>
    @if ($error)
        <div class="text-danger mt-1 text-sm">{{ $error }}</div>
    @endif
</div>