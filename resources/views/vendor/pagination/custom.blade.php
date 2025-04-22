@if ($paginator->hasPages())
<div class="basic-pagination text-center mt-35">
    <nav>
        <ul>
            {{-- Tombol Halaman Pertama --}}
            @if ($paginator->currentPage() > 2)
            <li>
                <a wire:click="gotoPage(1)" wire:loading.attr="disabled" style="cursor: pointer;">
                    <i class="icon-chevrons-left"></i>
                </a>
            </li>
            @endif

            {{-- Tombol Previous --}}
            <li>
                @if ($paginator->onFirstPage())
                <span class="disabled"><i class="icon-chevron-left"></i></span>
                @else
                <a wire:click="previousPage" wire:loading.attr="disabled" style="cursor: pointer;">
                    <i class="icon-chevron-left"></i>
                </a>
                @endif
            </li>

            {{-- Ringkas Page Number (current ±1) --}}
            @php
            $start = max($paginator->currentPage() - 1, 1);
            $end = min($paginator->currentPage() + 1, $paginator->lastPage());
            @endphp

            @for ($page = $start; $page <= $end; $page++)
                <li>
                @if ($page == $paginator->currentPage())
                <span class="current">{{ $page }}</span>
                @else
                <a wire:click="gotoPage({{ $page }})" wire:loading.attr="disabled" style="cursor: pointer;">
                    {{ $page }}
                </a>
                @endif
                </li>
                @endfor

                {{-- Tombol Next --}}
                <li>
                    @if ($paginator->hasMorePages())
                    <a wire:click="nextPage" wire:loading.attr="disabled" style="cursor: pointer;">
                        <i class="icon-chevron-right"></i>
                    </a>
                    @else
                    <span class="disabled"><i class="icon-chevron-right"></i></span>
                    @endif
                </li>

                {{-- Tombol ke Halaman Terakhir --}}
                @if ($paginator->currentPage() < $paginator->lastPage() - 1)
                    <li>
                        <a wire:click="gotoPage({{ $paginator->lastPage() }})" wire:loading.attr="disabled" style="cursor: pointer;">
                            <i class="icon-chevrons-right"></i>
                        </a>
                    </li>
                    @endif
        </ul>
    </nav>
</div>
@endif