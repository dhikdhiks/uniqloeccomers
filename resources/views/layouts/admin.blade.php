<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="author" content="surfside media" />
        {{-- css --}}
        <link rel="stylesheet" type="text/css" href="{{ asset('css/animate.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/animation.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-select.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('font/fonts.css') }}">
        <link rel="stylesheet" href="{{ asset('icon/style.css') }}">
        <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
        <link rel="apple-touch-icon-precomposed" href="{{ asset('images/favicon.ico') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
        @stack("styles")

        <!-- Tambahan style untuk memperbaiki tampilan user -->
        <style>
            .header-grid {
                display: flex;
                align-items: center;
                gap: 1rem; /* Jarak antar elemen di header-grid */
                margin-right: 2rem; /* Menggeser ke kiri dengan menambah margin kanan */
            }

            .popup-wrap.user.type-header {
                margin-right: 1rem; /* Menggeser lebih ke kiri */
            }

            .header-user.wg-user {
                display: flex;
                align-items: center;
                gap: 0.75rem; /* Jarak antara foto dan teks */
                max-width: 200px; /* Batasi lebar maksimum untuk mencegah overflow */
            }

            .header-user.wg-user .image {
                flex-shrink: 0; /* Pastikan foto tidak menyusut */
            }

            .header-user.wg-user .image img {
                width: 40px; /* Ukuran foto lebih besar */
                height: 40px;
                border-radius: 50%; /* Foto bulat */
                object-fit: cover;
            }

            .header-user.wg-user .flex-column {
                display: flex;
                flex-direction: column;
                max-width: 150px; /* Batasi lebar teks */
                overflow: hidden; /* Sembunyikan teks yang melebihi batas */
            }

            .header-user.wg-user .body-title {
                font-size: 1rem; /* Ukuran font nama */
                font-weight: 600;
                color: #333;
                white-space: nowrap; /* Pastikan teks tidak pindah baris */
                overflow: hidden;
                text-overflow: ellipsis; /* Tambahkan elipsis (...) jika teks terpotong */
            }

            .header-user.wg-user .text-tiny {
                font-size: 0.875rem; /* Ukuran font role */
                color: #666;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .dropdown-menu {
                min-width: 200px; /* Pastikan dropdown cukup lebar */
            }

            @media (max-width: 768px) {
                .header-grid {
                    margin-right: 1rem; /* Kurangi margin di perangkat mobile */
                }

                .header-user.wg-user {
                    max-width: 150px; /* Kurangi lebar maksimum di mobile */
                }

                .header-user.wg-user .image img {
                    width: 35px; /* Kurangi ukuran foto di mobile */
                    height: 35px;
                }

                .header-user.wg-user .body-title {
                    font-size: 0.9rem; /* Kurangi ukuran font di mobile */
                }

                .header-user.wg-user .text-tiny {
                    font-size: 0.75rem;
                }
            }
        </style>
    </head>
    <body class="body">
        <div id="wrapper">
            <div id="page" class="">
                <div class="layout-wrap">

                    <!-- <div id="preload" class="preload-container">
        <div class="preloading">
            <span></span>
        </div>
    </div> -->

                    <div class="section-menu-left">
                        <div class="box-logo">
                            <a href="{{ route('admin.index')}}" id="site-logo-inner">
                                <img class="" id="logo_header" alt="" src="{{ asset('/assets/images/logo/gg.png') }}"
                                    data-light="{{ asset('/assets/images/logo/gg.png') }}" data-dark="{{ asset('/assets/images/logo/gg.png') }}">
                            </a>

                            <div class="button-show-hide">
                                <i class="icon-menu-left"></i>
                            </div>
                        </div>
                        <div class="center">
                            <div class="center-item">
                                <div class="center-heading">Main Home</div>
                                <ul class="menu-list">
                                    <li class="menu-item">
                                        <a href="{{ route('admin.index')}}" class="">
                                            {{-- <div class="icon"><i class="icon-grid"></i></div> --}}
                                            <div class="text">Dashboard</div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="center-item">
                                <ul class="menu-list">
                                    <li class="menu-item has-children">
                                        <a href="javascript:void(0);" class="menu-item-button">
                                            <div class="icon"><i class="icon-shopping-cart"></i></div>
                                            <div class="text">Products</div>
                                        </a>
                                        <ul class="sub-menu">
                                            <li class="sub-menu-item">
                                                <a href="{{route('admin.product.add')}}" class="">
                                                    <div class="text">Add Product</div>
                                                </a>
                                            </li>
                                            <li class="sub-menu-item">
                                                <a href="{{route('admin.products')}}" class="">
                                                    <div class="text">Products</div>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="menu-item has-children">
                                        <a href="javascript:void(0);" class="menu-item-button">
                                            <div class="icon"><i class="icon-layers"></i></div>
                                            <div class="text">Brand</div>
                                        </a>
                                        <ul class="sub-menu">
                                            <li class="sub-menu-item">
                                                <a href="{{route('admin.brand.add')}}" class="">
                                                    <div class="text">New Brand</div>
                                                </a>
                                            </li>
                                            <li class="sub-menu-item">
                                                <a href="{{route('admin.brands')}}" class="">
                                                    <div class="text">Brands</div>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="menu-item has-children">
                                        <a href="javascript:void(0);" class="menu-item-button">
                                            <div class="icon"><i class="icon-layers"></i></div>
                                            <div class="text">Category</div>
                                        </a>
                                        <ul class="sub-menu">
                                            <li class="sub-menu-item">
                                                <a href="{{route('admin.category.add')}}" class="">
                                                    <div class="text">New Category</div>
                                                </a>
                                            </li>
                                            <li class="sub-menu-item">
                                                <a href="{{route('admin.categories')}}" class="">
                                                    <div class="text">Categories</div>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="menu-item has-children">
                                        <a href="javascript:void(0);" class="menu-item-button">
                                            <div class="icon"><i class="icon-file-plus"></i></div>
                                            <div class="text">Order</div>
                                        </a>
                                        <ul class="sub-menu">
                                            <li class="sub-menu-item">
                                                <a href="{{route('admin.orders')}}" class="">
                                                    <div class="text">Orders</div>
                                                </a>
                                            </li>
                                            <li class="sub-menu-item">
                                                <a href="order-tracking.html" class="">
                                                    <div class="text">Order tracking</div>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="menu-item">
                                        <a href="{{ route('admin.slides') }}" class="">
                                            <div class="icon"><i class="icon-image"></i></div>
                                            <div class="text">Slides</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="{{route('admin.coupons')}}" class="">
                                                <div class="icon">
                                                    <x-bxs-discount class="bxs-discount" />
                                                </div>
                                                <div class="text">Coupons</div>
                                        </li>
                                        </a>
                                    </li>

                                    <li class="menu-item">
                                        <a href="users.html" class="">
                                            <div class="icon"><i class="icon-user"></i></div>
                                            <div class="text">User</div>
                                        </a>
                                    </li>

                                    <li class="menu-item">
                                        <a href="settings.html" class="">
                                            <div class="icon"><i class="icon-settings"></i></div>
                                            <div class="text">Settings</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <form id="logout-form" method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <div class="icon"><i class="icon-settings"></i></div>
                                                <div class="text">Log Out</div>
                                            </a>
                                        </form>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="section-content-right">

                        <div class="header-dashboard">
                            <div class="wrap">
                                <div class="header-left">
                                    <a href="index-2.html">
                                        <img class="" id="logo_header_mobile" alt="" src="{{ asset('/assets/images/logo/gg.png') }}"
                                            data-light="{{ asset('/assets/images/logo/gg.png') }}" data-dark="{{ asset('images/logogg.png') }}"
                                            data-width="52px" data-height="52px" data-retina="{{ asset('/assets/images/logo/gg.png') }}">
                                    </a>
                                    <div class="button-show-hide">
                                        <i class="icon-menu-left"></i>
                                    </div>


                                    <form class="form-search flex-grow">
                                        <fieldset class="name">
                                            <input type="text" placeholder="Search here..." class="show-search" name="name"
                                                tabindex="2" value="" aria-required="true" required="">
                                        </fieldset>
                                        <div class="button-submit">
                                            <button class="" type="submit"><i class="icon-search"></i></button>
                                        </div>
                                        <div class="box-content-search" id="box-content-search">
                                            <ul class="mb-24">
                                                <li class="mb-14">
                                                    <div class="body-title">Top selling product</div>
                                                </li>
                                                <li class="mb-14">
                                                    <div class="divider"></div>
                                                </li>
                                                <li>
                                                    <ul>
                                                        <li class="product-item gap14 mb-10">
                                                            <div class="image no-bg">
                                                                <img src="{{ asset('images/products/17.png') }}" alt="">
                                                            </div>
                                                            <div class="flex items-center justify-between gap20 flex-grow">
                                                                <div class="name">
                                                                    <a href="product-list.html" class="body-text">Dog Food
                                                                        Rachael Ray Nutrish®</a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="mb-10">
                                                            <div class="divider"></div>
                                                        </li>
                                                        <li class="product-item gap14 mb-10">
                                                            <div class="image no-bg">
                                                                <img src="{{ asset('images/products/18.png') }}" alt="">
                                                            </div>
                                                            <div class="flex items-center justify-between gap20 flex-grow">
                                                                <div class="name">
                                                                    <a href="product-list.html" class="body-text">Natural
                                                                        Dog Food Healthy Dog Food</a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="mb-10">
                                                            <div class="divider"></div>
                                                        </li>
                                                        <li class="product-item gap14">
                                                            <div class="image no-bg">
                                                                <img src="{{ asset('images/products/19.png') }}" alt="">
                                                            </div>
                                                            <div class="flex items-center justify-between gap20 flex-grow">
                                                                <div class="name">
                                                                    <a href="product-list.html" class="body-text">Freshpet
                                                                        Healthy Dog Food and Cat</a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                            <ul class="">
                                                <li class="mb-14">
                                                    <div class="body-title">Order product</div>
                                                </li>
                                                <li class="mb-14">
                                                    <div class="divider"></div>
                                                </li>
                                                <li>
                                                    <ul>
                                                        <li class="product-item gap14 mb-10">
                                                            <div class="image no-bg">
                                                                <img src="{{ asset('images/products/20.png') }}" alt="">
                                                            </div>
                                                            <div class="flex items-center justify-between gap20 flex-grow">
                                                                <div class="name">
                                                                    <a href="product-list.html" class="body-text">Sojos
                                                                        Crunchy Natural Grain Free...</a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="mb-10">
                                                            <div class="divider"></div>
                                                        </li>
                                                        <li class="product-item gap14 mb-10">
                                                            <div class="image no-bg">
                                                                <img src="{{ asset('images/products/21.png') }}" alt="">
                                                            </div>
                                                            <div class="flex items-center justify-between gap20 flex-grow">
                                                                <div class="name">
                                                                    <a href="product-list.html" class="body-text">Kristin
                                                                        Watson</a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="mb-10">
                                                            <div class="divider"></div>
                                                        </li>
                                                        <li class="product-item gap14 mb-10">
                                                            <div class="image no-bg">
                                                                <img src="{{ asset('images/products/22.png') }}" alt="">
                                                            </div>
                                                            <div class="flex items-center justify-between gap20 flex-grow">
                                                                <div class="name">
                                                                    <a href="product-list.html" class="body-text">Mega
                                                                        Pumpkin Bone</a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="mb-10">
                                                            <div class="divider"></div>
                                                        </li>
                                                        <li class="product-item gap14">
                                                            <div class="image no-bg">
                                                                <img src="{{ asset('images/products/23.png') }}" alt="">
                                                            </div>
                                                            <div class="flex items-center justify-between gap20 flex-grow">
                                                                <div class="name">
                                                                    <a href="product-list.html" class="body-text">Mega
                                                                        Pumpkin Bone</a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </form>

                                </div>
                                <div class="header-grid">

                                    <div class="popup-wrap message type-header">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="header-item">
                                                    <span class="text-tiny">1</span>
                                                    <i class="icon-bell"></i>
                                                </span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end has-content"
                                                aria-labelledby="dropdownMenuButton2">
                                                <li>
                                                    <h6>Notifications</h6>
                                                </li>
                                                <li>
                                                    <div class="message-item item-1">
                                                        <div class="image">
                                                            <i class="icon-noti-1"></i>
                                                        </div>
                                                        <div>
                                                            <div class="body-title-2">Discount available</div>
                                                            <div class="text-tiny">Morbi sapien massa, ultricies at rhoncus
                                                                at, ullamcorper nec diam</div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="message-item item-2">
                                                        <div class="image">
                                                            <i class="icon-noti-2"></i>
                                                        </div>
                                                        <div>
                                                            <div class="body-title-2">Account has been verified</div>
                                                            <div class="text-tiny">Mauris libero ex, iaculis vitae rhoncus
                                                                et</div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="message-item item-3">
                                                        <div class="image">
                                                            <i class="icon-noti-3"></i>
                                                        </div>
                                                        <div>
                                                            <div class="body-title-2">Order shipped successfully</div>
                                                            <div class="text-tiny">Integer aliquam eros nec sollicitudin
                                                                sollicitudin</div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="message-item item-4">
                                                        <div class="image">
                                                            <i class="icon-noti-4"></i>
                                                        </div>
                                                        <div>
                                                            <div class="body-title-2">Order pending: <span>ID 305830</span>
                                                            </div>
                                                            <div class="text-tiny">Ultricies at rhoncus at ullamcorper</div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li><a href="#" class="tf-button w-full">View all</a></li>
                                            </ul>
                                        </div>
                                    </div>




                                    <div class="popup-wrap user type-header">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="header-user wg-user">
                                                    <span class="image">
                                                        <img src="{{ asset('images/avatar/user-1.png') }}" alt="">
                                                    </span>
                                                        <span class="flex flex-column">
                                                            <span class="body-title mb-2">{{ Auth::user()->name }}</span>
                                                            <span class="text-tiny"> {{ Auth::user()->utype === 'ADM' ? 'Admin' : 'User' }}</span>
                                                        </span>
                                                </span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end has-content"
                                                aria-labelledby="dropdownMenuButton3">
                                                <li>
                                                    <a href="#" class="user-item">
                                                        <div class="icon">
                                                            <i class="icon-user"></i>
                                                        </div>
                                                        <div class="body-title-2" href="{{route('admin.index')}}">Account</div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="user-item">
                                                        <div class="icon">
                                                            <i class="icon-mail"></i>
                                                        </div>
                                                        <div class="body-title-2">Inbox</div>
                                                        <div class="number">27</div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="user-item">
                                                        <div class="icon">
                                                            <i class="icon-file-text"></i>
                                                        </div>
                                                        <div class="body-title-2">Taskboard</div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="user-item">
                                                        <div class="icon">
                                                            <i class="icon-headphones"></i>
                                                        </div>
                                                        <div class="body-title-2">Support</div>
                                                    </a>
                                                </li>
                                                <li>
                                                    @csrf
                                                    <a href="{{route('logout')}}" class="user-item">
                                                        <div class="icon">
                                                            <i class="icon-log-out"></i>
                                                        </div>
                                                        <div class="body-title-2">Log out</div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="main-content">
                            @yield('content')

                            <div class="bottom-page">
                                <div class="body-text">Copyright © 2024 SurfsideMedia</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
        <script src="{{ asset('js/sweetalert.min.js') }}"></script>
        <script src="{{ asset('js/apexcharts/apexcharts.js') }}"></script>
        <script src="{{ asset('js/main.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            (function ($) {

                var tfLineChart = (function () {

                    var chartBar = function () {

                        var options = {
                            series: [{
                                name: 'Total',
                                data: [0.00, 0.00, 0.00, 0.00, 0.00, 273.22, 208.12, 0.00, 0.00, 0.00, 0.00, 0.00]
                            }, {
                                name: 'Pending',
                                data: [0.00, 0.00, 0.00, 0.00, 0.00, 273.22, 208.12, 0.00, 0.00, 0.00, 0.00, 0.00]
                            },
                            {
                                name: 'Delivered',
                                data: [0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00]
                            }, {
                                name: 'Canceled',
                                data: [0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00]
                            }],
                            chart: {
                                type: 'bar',
                                height: 325,
                                toolbar: {
                                    show: false,
                                },
                            },
                            plotOptions: {
                                bar: {
                                    horizontal: false,
                                    columnWidth: '10px',
                                    endingShape: 'rounded'
                                },
                            },
                            dataLabels: {
                                enabled: false
                            },
                            legend: {
                                show: false,
                            },
                            colors: ['#2377FC', '#FFA500', '#078407', '#FF0000'],
                            stroke: {
                                show: false,
                            },
                            xaxis: {
                                labels: {
                                    style: {
                                        colors: '#212529',
                                    },
                                },
                                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                            },
                            yaxis: {
                                show: false,
                            },
                            fill: {
                                opacity: 1
                            },
                            tooltip: {
                                y: {
                                    formatter: function (val) {
                                        return "$ " + val + ""
                                    }
                                }
                            }
                        };

                        chart = new ApexCharts(
                            document.querySelector("#line-chart-8"),
                            options
                        );
                        if ($("#line-chart-8").length > 0) {
                            chart.render();
                        }
                    };

                    /* Function ============ */
                    return {
                        init: function () { },

                        load: function () {
                            chartBar();
                        },
                        resize: function () { },
                    };
                })();

                jQuery(document).ready(function () { });

                jQuery(window).on("load", function () {
                    tfLineChart.load();
                });

                jQuery(window).on("resize", function () { });
            })(jQuery);
        </script>
    </body>
  @stack("scripts")
</html>
