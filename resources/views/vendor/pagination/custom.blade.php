@if ($paginator->hasPages())
<div class="basic-pagination text-center mt-35">
    <nav>
        <ul>
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
            <li><span class="disabled"><i class="icon-chevrons-left"></i></span></li>
            @else
            <li><a style="cursor: pointer;" wire:click="previousPage" wire:loading.attr="disabled" rel="prev"><i class="icon-chevrons-left"></i></a></li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
            @if (is_string($element))
            <li><span class="disabled">{{ $element }}</span></li>
            @endif

            @if (is_array($element))
            @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
            <li><span class="current">{{ $page }}</span></li>
            @else
            <li><a style="cursor: pointer;" wire:click="gotoPage({{ $page }})" wire:loading.attr="disabled">{{ $page }}</a></li>
            @endif
            @endforeach
            @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
            <li><a style="cursor: pointer;" wire:click="nextPage" wire:loading.attr="disabled"><i class="icon-chevrons-right"></i></a></li>
            @else
            <li><span class="disabled"><i class="icon-chevrons-right"></i></span></li>
            @endif
        </ul>
    </nav>
</div>
@endif