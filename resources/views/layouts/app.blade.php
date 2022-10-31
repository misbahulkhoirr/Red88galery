<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Data Ikan') }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" />
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style_fish.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <!-- ios support -->
    <link rel="manifest" href="//88pet.id/ios-88pet/manifest.json" />
    <link rel="apple-touch-icon" href="//88pet.id/ios-88pet/images/icons/icon-72x72.png" />
    <link rel="apple-touch-icon" href="//88pet.id/ios-88pet/images/icons/icon-96x96.png" />
    <link rel="apple-touch-icon" href="//88pet.id/ios-88pet/images/icons/icon-144x144.png" />
    <link rel="apple-touch-icon" href="//88pet.id/ios-88pet/images/icons/icon-192x192.png" />
    <meta name="apple-mobile-web-app-status-bar" content="#7a1710" />
    <meta name="theme-color" content="#7a1710" />

</head>
{{-- @dd(auth()->user()->role_id) --}}
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top cust-nav">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{asset('placeholder/logo.png')}}" width="40" alt=""> 88 Red Gallery
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse ms-auto" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @auth
                    <ul class="navbar-nav me-auto">

                        <li class="nav-item d-none d-sm-block ">
                            <a class="nav-link {{ Request::is('tank') ? 'active' : '' }}" href="{{ url('tank') }}">Tank</a>
                        </li>
                        <li class="nav-item d-none d-sm-block">
                            <a class="nav-link {{ Request::is('fish') ? 'active' : '' }}" href="{{ url('fish') }}">Ikan</a>
                        </li>

                        @if(auth()->user()->role_id == 1)
                        <li class="nav-item d-none d-sm-block">
                            <a class="nav-link {{ Request::is('sales') ? 'active' : '' }}" href="{{ url('sales') }}">Laporan Penjualan</a>
                        </li>
                        <li class="nav-item d-sm-block">
                            <a class="nav-link {{ Request::is('logs-users') ? 'active' : '' }}" href="{{ url('logs-users') }}">Logs Users</a>
                        </li>

                        <li class="nav-item dropdown d-none d-sm-block">
                            <a class="nav-link dropdown-toggle {{ Request::is('location','tank_types', 'size', 'fish_type', 'monthly_cost', 'supplier','users') ? 'active' : '' }}" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                                Master Data
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item {{ Request::is('location') ? 'active' : '' }}" href=" {{ url('location') }}">Lokasi</a>
                                <a class="dropdown-item {{ Request::is('tank_types') ? 'active' : '' }}" href="{{ url('tank_types') }}">Tipe Tank</a>
                                <a class="dropdown-item {{ Request::is('size') ? 'active' : '' }} " href="{{ url('size') }}">Ukuran</a>
                                <a class="dropdown-item {{ Request::is('fish_type') ? 'active' : '' }}" href="{{ url('fish_type') }}">Tipe Ikan</a>
                                <a class="dropdown-item {{ Request::is('monthly_cost') ? 'active' : '' }}" href="{{ url('monthly_cost') }}">Biaya Bulanan</a>
                                <a class="dropdown-item {{ Request::is('supplier') ? 'active' : '' }}" href="{{ url('supplier') }}">Supplier</a>
                                <a class="dropdown-item {{ Request::is('users') ? 'active' : '' }}" href="{{ url('users') }}">Users</a>
                            </div>
                        </li>

                        @elseif (auth()->user()->role_id == 4 || auth()->user()->role_id == 2)

                            @if (auth()->user()->role_id == 2)
                            <li class="nav-item d-none d-sm-block">
                                <a class="nav-link {{ Request::is('sales') ? 'active' : '' }}" href="{{ url('sales') }}">Laporan Penjualan</a>
                            </li>
                            <li class="nav-item dropdown d-none d-sm-block">
                                <a class="nav-link dropdown-toggle {{ Request::is('location','tank_types', 'size', 'fish_type', 'monthly_cost', 'supplier','users') ? 'active' : '' }}" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                                    Master Data
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item {{ Request::is('supplier') ? 'active' : '' }}" href="{{ url('supplier') }}">Supplier</a>
                                    <a class="dropdown-item {{ Request::is('users') ? 'active' : '' }}" href="{{ url('users') }}">Users</a>
                                </div>
                            </li>
                            @endif
                        @endif

                    </ul>
                    @endauth
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        {{-- @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif --}}
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ url('change-password') }}">
                                    {{ __('Ganti Password') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div style="margin-top: 100px; padding-bottom:100px;">
            <main>
                @yield('content')
            </main>
        </div>

        <!-- Bottom Navbar -->
        @auth
        <nav class="navbar navbar-dark bg-danger navbar-expand fixed-bottom d-md-none d-lg-none d-xl-none pt-2 pb-4 cust-nav">
            <ul class="navbar-nav nav-justified w-100">
                <li class="nav-item">
                    <a href="{{ url('tank') }}" class="nav-link {{ Request::is('tank') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16">
                            <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
                        </svg>
                        <span class="small d-block">Tank</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('fish') }}" class="nav-link {{ Request::is('fish') ? 'active' : '' }}">
                        <i class="fa-solid fa-fish-fins" style="font-size: 22px;"></i>
                        <span class="small d-block">Ikan</span>
                    </a>
                </li>
                @if (auth()->user()->role_id == 1)
                <li class="nav-item">
                    <a href="{{ url('sales') }}" class="nav-link {{ Request::is('sales') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="currentColor" class="bi bi-receipt" viewBox="0 0 16 16">
                            <path d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27zm.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.509.509.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0l-.509-.51z"/>
                            <path d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5z"/>
                        </svg>
                        <span class="small d-block">Laporan</span>
                    </a>
                </li>
                <li class="nav-item dropup">
                    <a href="#" class="nav-link text-center {{ Request::is('location','tank_types', 'size', 'fish_type', 'monthly_cost', 'supplier','users') ? 'active' : '' }}" role="button" id="dropdownMenuProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
                            <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
                            <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"/>
                        </svg>
                        <span class="small d-block m-data">M Data</span>
                    </a>
                    <!-- Dropup menu for profile -->
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuProfile">
                        <a class="dropdown-item {{ Request::is('location') ? 'active' : '' }}" href=" {{ url('location') }}">Lokasi</a>
                        <a class="dropdown-item {{ Request::is('tank_types') ? 'active' : '' }}" href="{{ url('tank_types') }}">Tipe Tank</a>
                        <a class="dropdown-item {{ Request::is('size') ? 'active' : '' }} " href="{{ url('size') }}">Ukuran</a>
                        <a class="dropdown-item {{ Request::is('fish_type') ? 'active' : '' }}" href="{{ url('fish_type') }}">Tipe Ikan</a>
                        <a class="dropdown-item {{ Request::is('monthly_cost') ? 'active' : '' }}" href="{{ url('monthly_cost') }}">Biaya Bulanan</a>
                        <a class="dropdown-item {{ Request::is('supplier') ? 'active' : '' }}" href="{{ url('supplier') }}">Supplier</a>
                        <a class="dropdown-item {{ Request::is('users') ? 'active' : '' }}" href="{{ url('users') }}">Users</a>
                    </div>
                </li>
                @elseif (auth()->user()->role_id == 4 || auth()->user()->role_id == 2)
                <li class="nav-item">
                    <a href="{{ url('sales') }}" class="nav-link {{ Request::is('sales') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="currentColor" class="bi bi-receipt" viewBox="0 0 16 16">
                            <path d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27zm.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.509.509.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0l-.509-.51z"/>
                            <path d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5z"/>
                        </svg>
                        <span class="small d-block">Laporan</span>
                    </a>
                </li>

                @if (auth()->user()->role_id == 2)
                <li class="nav-item dropup">
                    <a href="#" class="nav-link text-center {{ Request::is('location','tank_types', 'size', 'fish_type', 'monthly_cost', 'supplier','users') ? 'active' : '' }}" role="button" id="dropdownMenuProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
                            <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
                            <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"/>
                        </svg>
                        <span class="small d-block">M Data</span>
                    </a>
                    <!-- Dropup menu for profile -->
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuProfile">
                        <a class="dropdown-item {{ Request::is('supplier') ? 'active' : '' }}" href="{{ url('supplier') }}">Supplier</a>
                        <a class="dropdown-item {{ Request::is('users') ? 'active' : '' }}" href="{{ url('users') }}">Users</a>
                    </div>
                </li>
                @endif
                @endif

            </ul>
        </nav>
        @endauth

    </div>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.dropify').dropify();

            $('.dropify-clear').click(function(e) {
                e.preventDefault();
                alert('Remove Hit');

            });
        });
    </script> --}}
    <script>
        // NUMBERFORMAT
        const nodeList = document.querySelectorAll(".formatNumber");
        for (let i = 0; i < nodeList.length; i++) {
            nodeList[i].addEventListener('keyup', function(evt) {
                var n2 = this.value ? parseInt(this.value.replace(/\D/g, ''), 10) : 0;
                nodeList[i].value = n2.toLocaleString();
            }, false);
        }
        for (let i = 0; i < nodeList.length; i++) {
            const num = parseFloat(nodeList[i].defaultValue)
            nodeList[i].value = num ? num.toLocaleString() : ''
        }
    </script>
</body>
</html>
