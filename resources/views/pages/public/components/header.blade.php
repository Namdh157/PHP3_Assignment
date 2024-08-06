<div class="page-wrapper">
    <header class="header header-6">
        <div class="header-top">
            <div class="container">
                <div class="header-left">
                    <ul class="top-menu top-link-menu d-none d-md-block">
                        <li>
                            <a href="#">Links</a>
                            <ul>
                                <li><a href="tel:#"><i class="icon-phone"></i>Call: +0123 456 789</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <div class="header-right">
                    <div class="social-icons social-icons-color">
                        <a href="#" class="social-icon social-facebook" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                        <a href="#" class="social-icon social-twitter" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                        <a href="#" class="social-icon social-pinterest" title="Instagram" target="_blank"><i class="icon-pinterest-p"></i></a>
                        <a href="#" class="social-icon social-instagram" title="Pinterest" target="_blank"><i class="icon-instagram"></i></a>
                    </div>
                    <ul class="m-0">
                        <li>
                            @if (!$user)
                            <ul>
                                <a href="{{ route('login.form') }}"><i class="icon-user"></i>Login</a>
                            </ul>
                            @else
                            <div class="dropdown">
                                <button class="btn border-0 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="icon-user"></i> {{$user->name}}
                                </button>
                                <ul class="dropdown-menu">
                                    @if ($user->role == 'admin')
                                    <li class=" fs-5 mx-0 "><a class="dropdown-item" href="{{route('admin.dashboard')}}">Admin manager</a></li>
                                    <hr class="border-1 border-dark my-1">
                                    @endif
                                    <li class=" fs-5 mx-0 "><a class="dropdown-item" href="{{route('public.profile')}}">Profile setting</a></li>
                                    <li class=" fs-5 mx-0 "><a class="dropdown-item" href="{{route('public.cart')}}">Cart</a></li>
                                    <li class=" fs-5 mx-0 "><a class="dropdown-item" href="{{route('logout')}}">Logout <i class="fa-solid fa-arrow-right-from-bracket"></i></a></li>
                                </ul>
                            </div>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="header-middle">
            <div class="container">
                <div class="header-left">
                    <div class="header-search header-search-extended header-search-visible d-none d-lg-block">
                        <!-- <a href="#" class="search-toggle" role="button"><i class="icon-search"></i></a>
                        <form action="#" method="get">
                            <div class="header-search-wrapper search-wrapper-wide">
                                <label for="q" class="sr-only">Search</label>
                                <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
                                <input type="search" class="form-control" name="q" id="q" placeholder="Search product ..." required>
                            </div>
                        </form> -->
                    </div>
                </div>
                <div class="header-center">
                    <a href="/" class="logo">
                        <img src="{{ asset('storage/images') }}/components/logo.png" alt="Molla Logo" width="82" height="20">
                    </a>
                </div>
                <div class="header-right">
                    <div class="dropdown cart-dropdown">
                        <a href="{{ route('public.cart')}}" class="dropdown-toggle" role="button">
                            <i class="icon-shopping-cart"></i>
                            <span class="cart-count" id="cart-count">{{$countCart}}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="header-bottom sticky-header">
            <div class="container">
                <div class="header-left">
                    <nav class="main-nav">
                        <ul class="menu sf-arrows">
                            <li class="active">
                                <a href="/" class="">Home</a>
                            </li>
                            <li>
                                <a href="#" class="sf-with-ul">Shop</a>
                                <div class="megamenu megamenu-md">
                                    <div class="row no-gutters">
                                        <div class="col-md-8">
                                            <div class="menu-col">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="menu-title">Shop with Brands</div>
                                                        
                                                        <ul>
                                                            @foreach ($listBrands as $item)
                                                            <li>
                                                                <a href="{{ route('public.allProduct','brand[]='.$item->id) }}">{{$item->name}}</a>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="menu-title">Product Category</div>
                                                        
                                                        <ul>
                                                            @foreach ($listCatalogues as $item)
                                                            <li>
                                                                <a href="{{ route('public.allProduct','catalogue[]='.$item->id) }}">{{$item->name}}</a>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="banner banner-overlay">
                                                <a href="category.html" class="banner banner-menu">
                                                    <img src="{{ asset('storage/images') }}/components/header/menu/banner-1.jpg" alt="Banner">

                                                    <div class="banner-content banner-content-top">
                                                        <div class="banner-title text-white">Last
                                                            <br>Chance<br><span><strong>Sale</strong></span>
                                                        </div>
                                                        
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="#" class="sf-with-ul">Pages</a>
                                <ul>
                                    <li>
                                        <a href="#" class="">About</a>
                                    </li>
                                    <li>
                                        <a href="contact.html" class="">Contact</a>
                                    </li>
                                    <li><a href="#">FAQs</a></li>
                                    <li><a href="#">Error 404</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>

                    <button class="mobile-menu-toggler">
                        <span class="sr-only">Toggle mobile menu</span>
                        <i class="icon-bars"></i>
                    </button>
                </div>

                <div class="header-right">
                    <i class="la la-lightbulb-o"></i>
                    <p>Clearance Up to 30% Off</span></p>
                </div>
            </div>
        </div>
    </header>