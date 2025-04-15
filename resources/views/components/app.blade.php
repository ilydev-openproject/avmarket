<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Averros Herbal Indonesia | Toko Herbal Online</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('image/logo/icon.png') }}">

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
    @livewireStyles

    <style>
        @media screen and (max-width: 768px) {
            .img-prod {
                width: 100%;
            }

            .prod-list {
                display: flex;
                flex-direction: column;
                justify-content: center !important;
                align-items: start !important;
            }
        }

        @media screen and (min-width: 768px) {
            .img-prod {
                width: 100%;
                max-width: 300px;
            }
        }

        .text-success-custom {
            color: #96AE00 !important;
        }

        .tag-link:hover {
            color: #96AE00;
            /* warna hijau yang kamu pakai sebelumnya */
        }
    </style>
</head>

<body>
    <x-scrolltop></x-scrolltop>

    <x-header></x-header>

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
    <script src="{{ asset('orfarm/assets/js/nice-select.js') }}"></script>
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

    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('favorite-updated', () => {
                alert('Produk ditambahkan ke favorit!');
            });
        });
    </script>


    @livewireScripts
</body>

</html>