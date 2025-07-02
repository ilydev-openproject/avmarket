<!doctype html>
<html class="no-js" lang="zxx">
@props(['meta'])

<head>
    <meta name="google-site-verification" content="QyHv6G9P1HUqsm6MlywyapoSZa9FtZ3lMiaYrpqrO68" />
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $meta['meta_title'] ?? $meta['title'] }}</title>
    <meta name="description" content="{{ strip_tags($meta['meta_description'] ?? $meta['description']) }}">
    <meta name="keywords" content="{{ $meta['meta_keywords'] ?? $meta['keywords'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index,follow">
    <link rel="canonical" href="{{ $meta['meta_url'] ?? $meta['url'] }}">

    <!-- Open Graph -->
    <meta property="og:title" content="{{ $meta['meta_title'] ?? $meta['title'] }}">
    <meta property="og:description" content="{{ $meta['meta_description'] ?? $meta['description'] }}">
    <meta property="og:image" content="{{ $meta['meta_image'] ?? $meta['image'] }}">
    <meta property="og:url" content="{{ $meta['meta_url'] ?? $meta['url'] }}">
    <meta property="og:type" content="website">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $meta['meta_title'] ?? $meta['title'] }}">
    <meta name="twitter:description" content="{{ $meta['meta_description'] ?? $meta['description'] }}">
    <meta name="twitter:image" content="{{ $meta['meta_image'] ?? $meta['image'] }}">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/webp" href="{{ asset('image/logo/icon.png') }}">
    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('orfarm/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('orfarm/assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('orfarm/assets/css/swiper-bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('orfarm/assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('orfarm/assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('orfarm/assets/css/spacing.css') }}">
    <link rel="stylesheet" href="{{ asset('orfarm/assets/css/meanmenu.css') }}">
    <link rel="stylesheet" href="{{ asset('orfarm/assets/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('orfarm/assets/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('orfarm/assets/css/icon-dukamarket.css') }}">
    <link rel="stylesheet" href="{{ asset('orfarm/assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->

    @if (isset($product))
        {{-- ============================================= --}}
        {{-- UNTUK HALAMAN DETAIL PRODUK --}}
        {{-- ============================================= --}}
        <script type="application/ld+json">
                                {
                                    "@context": "https://schema.org",
                                    "@type": "Product",
                                    "name": "{{ $product->nama_product }}",
                                    "image": "{{ $product->getFirstMediaUrl('foto_product', 'thumbnail') }}",
                                    "description": "{{ \Str::limit(strip_tags($product->deskripsi), 250) }}",
                                    "sku": "{{ $product->bpom }}",
                                    "brand": {
                                        "@type": "Brand",
                                        "name": "{{ $product->brand }}"
                                    },
                                    "offers": {
                                        "@type": "Offer",
                                        "priceCurrency": "IDR",
                                        "price": "{{ $product->harga - ($product->harga * $product->diskon / 100) }}",
                                        "availability": "{{ $product->stok > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}",
                                        "url": "{{ url()->current() }}"
                                    }
                                }
                                </script>

    @elseif (isset($post))
        {{-- ============================================= --}}
        {{-- UNTUK HALAMAN DETAIL ARTIKEL/BLOG --}}
        {{-- ============================================= --}}
        <script type="application/ld+json">
                                {
                                    "@context": "https://schema.org",
                                    "@type": "Article",
                                    "headline": "{{ $post->meta_title ?? $post->title }}",
                                    "description": "{{ $post->meta_description ?? \Str::limit(strip_tags($post->content), 160) }}",
                                    "image": "{{ $post->getFirstMediaUrl('post_image', 'thumbnail') }}",
                                    "url": "{{ url()->current() }}",
                                    "datePublished": "{{ $post->created_at->toIso8601String() }}",
                                    "dateModified": "{{ $post->updated_at->toIso8601String() }}",
                                    "author": {
                                        "@type": "Organization",
                                        "name": "Gamora"
                                    },
                                    "publisher": {
                                        "@type": "Organization",
                                        "name": "Gamora",
                                        "logo": {
                                            "@type": "ImageObject",
                                            "url": "{{ asset('image/logo/icon.png') }}"
                                        }
                                    }
                                }
                                </script>

    @else
        {{-- ============================================= --}}
        {{-- UNTUK HALAMAN LAINNYA (HOMEPAGE, DLL) --}}
        {{-- ============================================= --}}
        <script type="application/ld+json">
                                {
                                    "@context": "https://schema.org",
                                    "@type": "WebPage",
                                    "name": "{{ $meta['meta_title'] ?? ($meta['title'] ?? 'Gamora Indonesia') }}",
                                    "description": "{{ $meta['meta_description'] ?? ($meta['description'] ?? 'Toko Herbal Online Terpercaya untuk Kesehatan dan Keintiman Anda.') }}",
                                    "url": "{{ url()->current() }}",
                                    "publisher": {
                                        "@type": "Organization",
                                        "name": "Gamora",
                                        "logo": {
                                            "@type": "ImageObject",
                                            "url": "{{ asset('image/logo/icon.png') }}"
                                        }
                                    }
                                }
                                </script>
    @endif


    @livewireStyles
</head>

<body>

    <x-scrolltop></x-scrolltop>

    <x-header :kategori-slug="$kategoriSlug ?? null" :tag-slug="$tagSlug ?? null"></x-header>

    <main>
        {{ $slot }}
    </main>

    <!-- footer-area-start -->
    <x-footer></x-footer>

    <!-- JS here -->
    <script src="{{ asset('orfarm/assets/js/jquery.js') }}"></script>
    <script src="{{ asset('orfarm/assets/js/waypoints.js') }}"></script>
    <script src="{{ asset('orfarm/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('orfarm/assets/js/swiper-bundle.js') }}"></script>
    <!-- <script src="{{ asset('orfarm/assets/js/nice-select.js') }}"></script> -->
    <script src="{{ asset('orfarm/assets/js/slick.js') }}"></script>
    <script src="{{ asset('orfarm/assets/js/magnific-popup.js') }}"></script>
    <script src="{{ asset('orfarm/assets/js/counterup.js') }}"></script>
    <script src="{{ asset('orfarm/assets/js/wow.js') }}"></script>
    <script src="{{ asset('orfarm/assets/js/isotope-pkgd.js') }}"></script>
    <script src="{{ asset('orfarm/assets/js/imagesloaded-pkgd.js') }}"></script>
    <script src="{{ asset('orfarm/assets/js/countdown.js') }}"></script>
    <script src="{{ asset('orfarm/assets/js/ajax-form.js') }}"></script>
    <script src="{{ asset('orfarm/assets/js/meanmenu.js') }}"></script>
    <script src="{{ asset('orfarm/assets/js/main.js') }}"></script>

    <!-- Toastr CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>


    @livewireScripts
    <script>
        Livewire.on('toastr', ({
            type,
            message
        }) => {
            toastr.options = {
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "3000",
                "positionClass": "toast-top-center",
            };
            toastr[type](message);
        });
    </script>
</body>

</html>