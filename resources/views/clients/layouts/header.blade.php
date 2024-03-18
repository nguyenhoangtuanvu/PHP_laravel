<!-- Start Main Top -->
<div class="main-top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="text-slid-box">
                        <div id="offer-box" class="carouselTicker">
                            <ul class="offer-box">
                                <li>
                                    <i class="fab fa-opencart"></i> Off 10%! Shop Now Man
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> 50% - 80% off on Fashion
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> 20% off Entire Purchase Promo code: offT20
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> Off 50%! Shop Now
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> Off 10%! Shop Now Man
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> 50% - 80% off on Fashion
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> 20% off Entire Purchase Promo code: offT20
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> Off 50%! Shop Now
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="custom-select-box">
                        <select id="basic" class="selectpicker show-tick form-control" data-placeholder="$ USD">
						<option>¥ JPY</option>
						<option>$ USD</option>
						<option>€ EUR</option>
					</select>
                    </div>
                    <div class="right-phone-box">
                        <p>Call US :- <a href="#"> +0935 794 380 / {{auth()->check()}}</a></p>
                    </div>
                    <div class="our-link">
                        <ul>
                            @if (auth()->check())
                            <li>
                                <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
    
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                                
                            @else
                            <li><a href="{{route('login')}}">Login</a></li>
                            <li><a href="#">Rejstter</a></li>
                            @endif

                            <li><a href="#">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Main Top -->

    <!-- Start Main Top -->
    <header class="main-header">
        <!-- Start Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-default bootsnav">
            <div class="container">
                <!-- Start Header Navigation -->
                <div class="navbar-header">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                    <a class="navbar-brand" href="{{ route('client.shop.index')}}"><img src="{{ asset('client/assets/images/logo.png')}}" class="logo" alt=""></a>
                </div>
                <!-- End Header Navigation -->

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <ul class="nav navbar-nav ml-auto" data-in="fadeInDown" data-out="fadeOutUp">
                        <li class="nav-item {{request()->routeIs('client.home') ? 'active' :'' }}"><a class="nav-link" href="{{ route('client.home')}}">Home</a></li>
                        <li class="nav-item {{request()->routeIs('about') ? 'active' :'' }}"><a class="nav-link" href="{{ route('about')}}">About Us</a></li>
                        <li class="dropdown megamenu-fw {{request()->routeIs('client.shop.*') ? 'active' :'' }}">
                            <a href="{{ route('client.shop.index')}}" class="nav-link dropdown-toggle arrow" data-toggle="dropdown">Product</a>
                            <ul class="dropdown-menu megamenu-content" role="menu">
                                <li>
                                    <div class="row">
                                        <div class="col-menu col-md-3">
                                            <h6 class="title"><a href="{{ route('client.shop.index')}}">All PRODUCTS</a></h6>
                                        </div>
                                        @foreach ($categories as $category)
                                        <div class="col-menu col-md-3">
                                            <h6 class="title"><a href="{{ route('client.shop.indexFilter', ['category_id' => $category->id])}}">{{$category->name}}</a></h6></h6>
                                            <div class="content">
                                                <ul class="menu-col">
                                                    @foreach ($category->children as $child)
                                                    <li><a href="{{ route('client.shop.indexFilter', ['category_id' => $child->id])}}">{{$child->name}}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        @endforeach

                                    </div>
                                    <!-- end row -->
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown {{request()->routeIs('cart') ? 'active' :'' }}">
                            <a href="#" class="nav-link dropdown-toggle arrow" data-toggle="dropdown">SHOP</a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('cart')}}">Cart</a></li>
                                <li><a href="{{ route('checkOut')}}">Checkout</a></li>
                                <li><a href="{{ route('client.shop.index')}}">Favorite</a></li>
                            </ul>
                        </li>
                        <li class="nav-item {{request()->routeIs('orders') ? 'active' :'' }}"><a class="nav-link" href="{{route('orders')}}">Orders</a></li>
                        <li class="nav-item {{request()->routeIs('contact') ? 'active' :'' }}"><a class="nav-link" href="{{route('contact')}}">Contact Us</a></li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->

                <!-- Start Atribute Navigation -->
                <div class="attr-nav">
                    <ul>
                        <li class="search"><a href="#"><i class="fa fa-search"></i></a></li>
                        <li class="side-menu"><a href="#">
						<i class="fa fa-shopping-bag"></i>
                            <span class="badge" id="productCountCart">{{ $countProductInCart }}</span>
					</a></li>
                    </ul>
                </div>
                <!-- End Atribute Navigation -->
            </div>
            <!-- Start Side Menu -->
            <div class="side">
                <a href="#" class="close-side"><i class="fa fa-times"></i></a>
                <li class="cart-box">
                    <ul class="cart-list">
                        {{-- @foreach ($productInCart->products as $item)
                        <li>
                            <a href="{{route('client.shop.show', $item->id)}}">
                                <a href="{{route('client.shop.show', $item->id)}}" class="photo"><img src="{{ asset('upload/'. $item->images->first()->url)}}" class="cart-thumb" alt="" /></a>
                                <h6><a href="{{route('client.shop.show', $item->id)}}">{{$item->name}}</a></h6>
                                <p>{{$item->pivot->product_quantity}}- <span class="price">${{number_format($item->price, 0, '', ',')}}</span></p>
                            </a>
                        </li>
                            
                        @endforeach --}}
                        <li class="total">
                            <a href="{{route('cart')}}" class="btn btn-default hvr-hover btn-cart">VIEW CART</a>
                            <span class="float-right"><strong>Total</strong>: ${{number_format($totalProductInCart, 0, '', ',')}}</span>
                        </li>
                    </ul>
                </li>
            </div>
            <!-- End Side Menu -->
        </nav>
        <!-- End Navigation -->
    </header>
    <!-- End Main Top -->

    <!-- Start Top Search -->
    <div class="top-search">
        <div class="container">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control" placeholder="Search">
                <span class="input-group-addon close-search"><i class="fa fa-times"></i></span>
            </div>
        </div>
    </div>
    <!-- End Top Search -->

    <!-- Start All Title Box -->
    @unless (request()->routeIs('client.home'))
    <div class="all-title-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Shop</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Shop</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
        
    @endunless
    <!-- End All Title Box -->