<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>@yield('title')</title>

    @stack('prepend-style')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link href="/style/main.css" rel="stylesheet" />
    @stack('addon-style')
</head>

<body>
    <div class="page-dashboard">
        <div class="d-flex" id="wrapper" data-aos="fade-right">
            <!-- Sidebar -->
            <div class="border-right" id="sidebar-wrapper">
                <div class="sidebar-heading text-center">
                    <a href="{{ route('home') }}" class="navbar-brand">
                        <img src="/images/logo.svg" alt="logo" />
                    </a>
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('dashboard') }}"
                        class="list-group-item list-group-item-action {{ request()->is('dashboard') ? 'active' : '' }}">Dashboard
                    </a>
                    <a href="{{ route('dashboard-product') }}"
                        class="list-group-item list-group-item-action {{ request()->is('dashboard/product*') ? 'active' : '' }}">My
                        Products
                    </a>
                    <a href="{{ route('dashboard-transactions') }}"
                        class="list-group-item list-group-item-action {{ request()->is('dashboard/transactions*') ? 'active' : '' }}">Transactions
                    </a>
                    <a href="{{ route('dashboard-setting-store') }}"
                        class="list-group-item list-group-item-action {{ request()->is('dashboard/setting*') ? 'active' : '' }}">Store
                        Settings
                    </a>
                    <a href="{{ route('dashboard-setting-account') }}"
                        class="list-group-item list-group-item-action {{ request()->is('dashboard/account*') ? 'active' : '' }}">My
                        Account
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="">
                        @csrf
                        <a href="route('logout')"
                            onclick="event.preventDefault();
                              this.closest('form').submit();"
                            class="list-group-item list-group-item-action">Sign Out
                        </a>
                    </form>
                </div>
            </div>


            <!-- Page Content -->
            <div id="page-content-wrapper">
                <nav class="navbar navbar-expand-lg navbar-light navbar-store fixed-top" data-aos="fade-down">
                    <div class="container-fluid">
                        <button class="btn btn-secondary d-md-none mr-auto mr-2" id="menu-toggle">
                            &laquo; Menu
                        </button>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <!-- Desktop Menu -->
                            <ul class="navbar-nav d-none d-lg-flex ml-auto">
                                <li class="nav-item dropdown">
                                    <a href="#" class="nav-link" id="navbarDropdown" role="button"
                                        data-toggle="dropdown">
                                        <img src="/images/user-icon/icon-user.png" alt="Icon User"
                                            class="rounded-circle mr-2 profile-picture" />
                                        Hi, {{ Auth::user()->name }}
                                    </a>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('dashboard') }}" class="dropdown-item">Dasbohard</a>
                                        <a href="{{ route('dashboard-setting-account') }}"
                                            class="dropdown-item">Setting</a>

                                        <div class="dropdown-divider"></div>
                                        {{-- <a href="/" class="dropdown-item">Logout</a> --}}
                                        <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                            @csrf

                                            <a href="route('logout')"
                                                onclick="event.preventDefault();
                                              this.closest('form').submit();"
                                                class="dropdown-item cursor-pointer">Log Out
                                            </a>
                                        </form>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('cart') }}" class="nav-link d-inline-block mt-2">
                                        {{-- Mengambil data cart --}}
                                        @php
                                            $carts = \App\Models\Cart::where('users_id', Auth::user()->id)->count();
                                        @endphp
                                        @if ($carts > 0)
                                            <img src="/images/icons/cart-filled.svg" alt="icon-cart" />
                                            <div class="card-badge">{{ $carts }}</div>
                                        @else
                                            <img src="/images/icons/cart-empty.svg" alt="icon-cart" />
                                        @endif

                                    </a>
                                </li>
                            </ul>

                            <!-- Mobile Menu -->
                            <ul class="navbar-nav d-block d-lg-none">
                                <li class="nav-item">
                                    <a href="#" class="nav-link"> Hi, {{ Auth::user()->name }} </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('cart') }}" class="nav-link d-inline-block"> Cart </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                {{-- Content --}}
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    @stack('prepend-script')
    <script src="/vendor/jquery/jquery.slim.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <!-- untuk menampilkan / menghilangkan menu di Mobile -->
    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
    @stack('addon-script')
</body>

</html>
