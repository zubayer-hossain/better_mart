@php
    $route = Route::current();
    $name = Route::currentRouteName();
    $action = Route::currentRouteAction();
@endphp
<style>
    .dropdown-menu a:hover {
        color: #ff2f2f !important;
    }
    .dropdown-menu a{
        color: black !important;
        font-size: 14px!important;
    }
</style>
<header class="header-area">
    <div class="header-large-device">
        <div class="header-middle header-middle-padding-2">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-2 col-lg-2">
                        <div class="logo">
                            <a href="/"><img style="margin: 5px 0 0;width: 170px; height: 55px;"
                                             src="{{ asset('uploads/logo.png') }}" alt="Proactive Servicing"></a>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="categori-search-wrap categori-search-wrap-modify-3">
                            <div class="search-wrap-3">
                                <form action="#">
                                    <input id="search_text" placeholder="Search Products..." type="text"
                                           value="{{ $_GET['search'] ?? '' }}">
                                    <button onclick="searchProduct();" id="search_button" type="button" class="blue"><i
                                            class="lnr lnr-magnifier"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-1 col-lg-1">
                        @if (isset($_GET['search']) && trim($_GET['search']) !== '')
                            <button onclick="resetSearch();" type="button" class="btn btn-primary">Reset</button>
                        @endif
                    </div>
                    <div class="col-xl-3 col-lg-3">
                        <div class="hotline-2-wrap">
                            <div class="hotline-2-icon">
                                <i class="blue icon-call-end"></i>
                            </div>
                            <div class="hotline-2-content">
                                <span> Hotline 24/7</span>
                                <h5>+88018XXXXXXXX</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom bg-blue">
            <div class="container">
                <div class="row align-items-center">
                    <div class=" col-lg-3">
                        <div class="main-categori-wrap main-categori-wrap-modify-2">
                            <a class="categori-show categori-blue" href="#">Categories <i
                                    class="icon-arrow-down icon-right"></i></a>
                            <div class="category-menu-2 category-menu-2-blue categori-hide categori-not-visible-2">
                                <nav>
                                    <ul>
                                        <li><a href="/">All Categories</a></li>
                                        @foreach($categories as $category)
                                            <li>
                                                <a href="/?search_category={{ $category->id  ?? '' }}">{{ $category->name ?? '' }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div
                            class="main-menu main-menu-white main-menu-padding-1 main-menu-font-size-14 main-menu-lh-5">
                            <nav>
                                <ul>
                                    <li><a href="/">HOME </a></li>
                                    <li><a href="/#products_block">PRODUCTS </a></li>
                                    <!--<li><a href="/services">SERVICES </a></li>-->
                                    <li><a href="/about-us">ABOUT US </a></li>
                                    <li><a href="/contact-us">CONTACT US </a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="header-action header-action-flex pr-20">
                            <div class="same-style-2 same-style-2-white same-style-2-font-dec">
                                @guest
                                    @if (Route::has('login'))
                                        <a style="font-size: 14px!important;" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    @endif

                                    @if (Route::has('register'))
                                           <span style="color: white">/</span> <a style="font-size: 14px!important;" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    @endif
                                @else
                                    <ul>
                                        <li class="nav-item dropdown">
                                            <a style="font-size: 14px!important;" id="navbarDropdown" class="nav-link dropdown-toggle" href="#"
                                               role="button" data-toggle="dropdown" aria-haspopup="true"
                                               aria-expanded="false" v-pre>
                                                <i class="icon-user"></i>
                                                {{ Auth::user()->name }}
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right"
                                                 aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="{{ route('my_account') }}">
                                                    My Account
                                                </a>
                                                <hr>
                                                <a class="dropdown-item" href="{{ route('logout') }}"
                                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                    {{ __('Logout') }}
                                                </a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                      class="d-none">
                                                    @csrf
                                                </form>
                                            </div>
                                        </li>
                                    </ul>
                                @endguest
                            </div>
                            <div class="same-style-2 same-style-2-white same-style-2-font-dec header-cart my-auto">
                                <a class="cart-active" href="#">
                                    <span id="cart_count">
                                        <i class="icon-basket-loaded"></i>
                                        <span class="pro-count red">{{ count((array) session('cart')) }}</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-small-device small-device-ptb-1">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-5">
                    <div class="mobile-logo">
                        <a href="/">
                            <a href="/"><img style="margin: 5px 0 0;width: 170px; height: 45px;"
                                             src="{{ asset('uploads/logo.png') }}" alt="logo"></a>
                        </a>
                    </div>
                </div>
                <div class="col-7">
                    <div class="header-action header-action-flex justify-content-center">
                        <div class="same-style-2 same-style-2-font-inc mr-0">
                            @guest
                                @if (Route::has('login'))
                                    <a style="font-size: 14px!important;" href="{{ route('login') }}">{{ __('Login') }}</a>
                                @endif

                                @if (Route::has('register'))
                                    <span style="color: white">/</span> <a style="font-size: 14px!important;" href="{{ route('register') }}">{{ __('Register') }}</a>
                                @endif
                            @else
                                <ul>
                                    <li class="nav-item dropdown">
                                        <a  id="navbarDropdown" class="nav-link dropdown-toggle" href="#"
                                           role="button" data-toggle="dropdown" aria-haspopup="true"
                                           aria-expanded="false" v-pre>
                                            <i class="icon-user"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right"
                                             aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{ route('my_account') }}">
                                                My Account
                                            </a>
                                            <hr>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                  class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            @endguest
                        </div>
                        <div class="same-style-2 same-style-2-font-inc header-cart">
                            <a class="cart-active" href="#">
                                <span id="cart_count_mobile">
                                    <i class="icon-basket-loaded"></i>
                                    <span class="pro-count red">{{ count((array) session('cart')) }}</span>
                                </span>
                            </a>
                        </div>
                        <div class="same-style-2 main-menu-icon">
                            <a class="mobile-header-button-active" href="#"><i class="icon-menu"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- mobile header start -->
<div class="mobile-header-active mobile-header-wrapper-style">
    <div class="clickalbe-sidebar-wrap">
        <a class="sidebar-close"><i class="icon_close"></i></a>
        <div class="mobile-header-content-area">
            <div class="mobile-search mobile-header-padding-border-1">
                <form class="search-form" action="#">
                    <input id="mobile_search_text" type="text" placeholder="Search here…"
                           value="{{ $_GET['search'] ?? '' }}">
                    <button onclick="searchProductMobile();" id="search_button" type="button" class="button-search"><i
                            class="icon-magnifier"></i></button>
                </form>
                <div class="ml-2 mt-2">
                    @if (isset($_GET['search']) && trim($_GET['search']) !== '')
                        <button onclick="resetSearch();" type="button" class="btn btn-primary">Reset</button>
                    @endif
                </div>
            </div>
            <div class="mobile-menu-wrap mobile-header-padding-border-2">
                <!-- mobile menu start -->
                <nav>
                    <ul class="mobile-menu">
                        <li><a href="/">HOME </a></li>
                        <li><a href="/#products_block">PRODUCTS </a></li>
                        <li><a href="/services">SERVICES </a></li>
                        <li><a href="/about-us">ABOUT US </a></li>
                        <li><a href="/contact-us">CONTACT US </a></li>
                    </ul>
                </nav>
                <!-- mobile menu end -->
            </div>
            <div class="main-categori-wrap mobile-menu-wrap mobile-header-padding-border-3">
                <a class="categori-show blue" href="#">
                    <i class="lnr lnr-menu"></i> All Categories <i class="icon-arrow-down icon-right"></i>
                </a>
                <div class="categori-hide-2">
                    <nav>
                        <ul class="mobile-menu">
                            <li><a href="/">All Categories</a></li>
                            @foreach($categories as $category)
                                <li>
                                    <a href="/?search_category={{ $category->id  ?? '' }}">{{ $category->name  ?? '' }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="mobile-contact-info mobile-header-padding-border-4">
                <ul>
                    <li><i class="icon-phone "></i> +88018XXXXXXXX</li>
                    <li><i class="icon-envelope-open "></i> demo@gamil.com</li>
                    <li><i class="icon-home"></i> Mirpur-2, Dhaka.</li>
                </ul>
            </div>
            <div class="mobile-social-icon">
                <a class="facebook" href="#"><i class="icon-social-facebook"></i></a>
                <a class="twitter" href="#"><i class="icon-social-twitter"></i></a>
            </div>
        </div>
    </div>
</div>

<div class="sidebar-cart-active">
    <div class="sidebar-cart-all">
        <a class="cart-close" href="#"><i class="icon_close"></i></a>
        <div class="cart-content" id="product_cart_div">
            <h3>Shopping Cart</h3>
            @if(session('cart'))
                <ul>
                    @forelse(session('cart') as $id => $details)
                        <li class="single-product-cart">
                            <div class="cart-img">
                                <a href="/product-details/{{ $details['product_code'] ?? '' }}"><img
                                        src="{{ asset($details['image'])  ?? '' }}" alt="{{ $details['name'] }}"></a>
                            </div>
                            <div class="cart-title">
                                <h4><a href="/product-details/{{ $details['product_code']  ?? '' }}">{{ $details['name']  ?? '' }}</a>
                                </h4>
                                <span> {{ $details['quantity']  ?? '' }} × ৳ {{ $details['price']  ?? '' }}	</span>
                            </div>
                            <div class="cart-delete my-auto">
                                <button class="btn btn-danger btn-sm" style="height: fit-content!important;"
                                        type="button" onclick="removeFromCart({{ $id }}, 'sidebar_cart')">×
                                </button>
                            </div>
                        </li>
                    @empty
                        <li>No products in cart</li>
                    @endforelse
                </ul>
                @php $total = 0 @endphp
                @foreach((array) session('cart') as $id => $details)
                    @php $total += $details['price'] * $details['quantity'] @endphp
                @endforeach
                <div class="cart-total">
                    <h4>Subtotal: <span>৳ {{ $total }} Tk</span></h4>
                </div>
                <div class="cart-checkout-btn">
                    <a class="no-mrg btn-hover cart-btn-style" href="{{ route('cart') }}">View Cart</a>
                </div>
            @else
                <div>No products in cart</div>
            @endif
        </div>
    </div>
</div>
