<div class="header__info-cart tpcolor__oasis ml-10 tp-cart-toggle">
    <button><i><img src="{{ asset('orfarm/assets/img/icon/cart-1.svg') }}" alt=""></i>
        @if($count > 0)
        <span>{{ $count }}</span>
        @endif
    </button>
</div>