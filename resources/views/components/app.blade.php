<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $meta['title'] }}</title>
    <meta name="description" content="{{ $meta['description'] }}">
    <meta name="keywords" content="{{ $meta['keywords'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index,follow">
    <link rel="canonical" href="{{ $meta['url'] }}">

    <!-- Open Graph -->
    <meta property="og:title" content="{{ $meta['title'] }}">
    <meta property="og:description" content="{{ $meta['description'] }}">
    <meta property="og:image" content="{{ $meta['image'] }}">
    <meta property="og:url" content="{{ $meta['url'] }}">
    <meta property="og:type" content="website">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $meta['title'] }}">
    <meta name="twitter:description" content="{{ $meta['description'] }}">
    <meta name="twitter:image" content="{{ $meta['image'] }}">

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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @if (isset($product))
        <script type="application/ld+json">
                {
                    "@context": "https://schema.org",
                    "@type": "Product",
                    "name": "{{ $product->name }}",
                    "image": "{{ asset('image/produk/' . $product->image) }}",
                    "description": "{{ \Str::limit($product->description, 160) }}",
                    "sku": "{{ $product->sku }}",
                    "brand": {
                        "@type": "Brand",
                        "name": "Gamora"
                    },
                    "offers": {
                        "@type": "Offer",
                        "priceCurrency": "IDR",
                        "price": "{{ $product->price }}",
                        "availability": "https://schema.org/InStock",
                        "url": "{{ $meta['url'] }}"
                    }
                }
                </script>
    @else
        <script type="application/ld+json">
                {
                    "@context": "https://schema.org",
                    "@type": "WebPage",
                    "name": "{{ $meta['title'] }}",
                    "description": "{{ $meta['description'] }}",
                    "url": "{{ $meta['url'] }}",
                    "publisher": {
                        "@type": "Organization",
                        "name": "Gamora",
                        "logo": "{{ asset('image/logo/icon.png') }}"
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


    @livewireScripts
    <!-- Toastr CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>


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