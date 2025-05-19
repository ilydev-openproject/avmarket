<div class="custom-autocomplete" x-data="{ search: '', open: false }" x-init="search = '{{ $provinceName ?? '' }}'">
    <input type="text" x-model="search" @input="open = true" @click="open = true" @keydown.esc="open = false"
        placeholder="Ketik provinsi..." class="autocomplete-input" wire:model.debounce.500ms="selectedId"
        wire:loading.attr="disabled">
    <div class="autocomplete-options" x-show="open" x-cloak x-transition wire:key="province-options">
        <template x-for="option in $wire.provinces.filter(p => 
            search ? p.name.toLowerCase().includes(search.toLowerCase()) : true
        )" :key="option . id">
            <div class="option" @click="$wire.set('selectedId', option.id); 
                search = option.name; open = false" x-text="option.name"></div>
        </template>
        <div class="option option-empty" x-show="!$wire.provinces.filter(p => 
            search ? p.name.toLowerCase().includes(search.toLowerCase()) : true
        ).length">Tidak ada hasil</div>
    </div>
    @if ($error)
        <div class="text-danger mt-1 text-sm">{{ $error }}</div>
    @endif
</div>