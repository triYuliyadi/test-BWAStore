<nav class="navbar navbar-expand-lg navbar-light navbar-store fixed-top navbar-fixed-top" data-aos="fade-down">
    <div class="container">
        <a href="{{ route('home') }}" class="navbar-brand">
            <img src="/images/logo.svg" alt="logo" />
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('categories') }}" class="nav-link">Categories</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Rewards</a>
                </li>
                @guest
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="nav-link">Sign Up</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link btn btn-success px-4 text-white">Sign In</a>
                    </li>
                @endguest
            </ul>
            @auth
                <!-- Desktop Menu -->
                <ul class="navbar-nav d-none d-lg-flex">
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link" id="navbarDropdown" role="button" data-toggle="dropdown">
                            <img src="/images/user-icon/icon-user.png" alt="Icon User"
                                class="rounded-circle mr-2 profile-picture" />
                            Hi, {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu">
                            <a href="{{ route('dashboard') }}" class="dropdown-item">Dasboard</a>
                            <a href="{{ route('dashboard-setting-account') }}" class="dropdown-item">Setting</a>

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
                               $carts =  \App\Models\Cart::where('users_id', Auth::user()->id)->count();
                            @endphp
                            @if ( $carts > 0 )
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
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="">
                            @csrf

                            <a href="route('logout')"
                                onclick="event.preventDefault();
                                    this.closest('form').submit();"
                                class="nav-link cursor-pointer">Log Out
                            </a>
                        </form>
                    </li>

                </ul>
            @endauth
        </div>
    </div>
</nav>
