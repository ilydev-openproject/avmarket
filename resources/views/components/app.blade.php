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
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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

            .cust-prod {
                max-width: 150px;
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

        .qty-btn {
            border: 1px solid #96AE00 !important;
            width: 100px;
            background-color: #EDEDED;
            border-radius: 12px;
            overflow: hidden;
        }

        .cust-minus,
        .cust-plus {
            padding: 0 10px;
            cursor: pointer;
            margin: 0;
            width: 100%;
            height: 30px;
            border: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .qty-btn>.cust-plus:hover {
            background-color: #D5D5D5;
        }

        .qty-btn>.cust-minus:hover {
            background-color: #D5D5D5;
        }

        ul.list {
            max-height: 200px;
            overflow-y: scroll !important;
        }

        .form-select {
            border-radius: 0 !important;
            border: .5px solid #eaedff;
            height: 45px;
        }

        .form-select:focus {
            outline: .5px solid #0000 !important;
            box-shadow: 0 0 0 1px rgba(0, 0, 0, 1);
            border-color: transparent;
        }

        /* Loading untuk select */
        .select-loading {
            position: relative;
        }

        .select-loading::after {
            content: "";
            position: absolute;
            right: 30px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #0d6efd;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        /* Loading untuk card kurir */
        .shipping-loading {
            position: relative;
            min-height: 120px;
            overflow: hidden;
        }

        .shipping-loading::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, 0.8);
            z-index: 1;
        }

        .shipping-loading::after {
            content: "";
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 30px;
            height: 30px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #0d6efd;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            z-index: 2;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        a.no-after::after {
            display: none !important;
        }

        .main-menu ul li a.no-after {
            padding: 0 !important;
            /* margin-bottom: 20px; */
        }

        .uploadfoto {
            appearance: base;
        }

        .uploadfoto label {
            background-color: indigo;
            color: white;
            padding: 0.5rem;
            font-family: sans-serif;
            border-radius: 0.3rem;
            cursor: pointer;
            margin-top: 1rem;
        }
    </style>
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