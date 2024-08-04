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
                    </ul><!-- End .top-menu -->
                </div><!-- End .header-left -->

                <div class="header-right">
                    <div class="social-icons social-icons-color">
                        <a href="#" class="social-icon social-facebook" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                        <a href="#" class="social-icon social-twitter" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                        <a href="#" class="social-icon social-pinterest" title="Instagram" target="_blank"><i class="icon-pinterest-p"></i></a>
                        <a href="#" class="social-icon social-instagram" title="Pinterest" target="_blank"><i class="icon-instagram"></i></a>
                    </div><!-- End .soial-icons -->
                    <ul class="top-menu top-link-menu">
                        <li>
                            <ul>
                                <a href="{{ route('login.form') }}"><i class="icon-user"></i>Login</a>
                            </ul>
                        </li>
                    </ul><!-- End .top-menu -->
                </div><!-- End .header-right -->
            </div>
        </div>
        <div class="header-middle">
            <div class="container">
                <div class="header-left">
                    <div class="header-search header-search-extended header-search-visible d-none d-lg-block">
                        <a href="#" class="search-toggle" role="button"><i class="icon-search"></i></a>
                        <form action="#" method="get">
                            <div class="header-search-wrapper search-wrapper-wide">
                                <label for="q" class="sr-only">Search</label>
                                <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
                                <input type="search" class="form-control" name="q" id="q" placeholder="Search product ..." required>
                            </div><!-- End .header-search-wrapper -->
                        </form>
                    </div><!-- End .header-search -->
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
                    </div><!-- End .cart-dropdown -->
                </div>
            </div><!-- End .container -->
        </div><!-- End .header-middle -->

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
                                                        <!-- End .menu-title -->
                                                        <ul>
                                                            @foreach ($listBrands as $item)
                                                            <li>
                                                                <a href="{{ route('public.allProduct','brand='.$item->id) }}">{{$item->name}}</a>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div><!-- End .col-md-6 -->
                                                    <div class="col-md-6">
                                                        <div class="menu-title">Product Category</div>
                                                        <!-- End .menu-title -->
                                                        <ul>
                                                            @foreach ($listCatalogues as $item)
                                                            <li>
                                                                <a href="{{ route('public.allProduct','catalogue='.$item->id) }}">{{$item->name}}</a>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div><!-- End .col-md-6 -->
                                                </div><!-- End .row -->
                                            </div><!-- End .menu-col -->
                                        </div><!-- End .col-md-8 -->

                                        <div class="col-md-4">
                                            <div class="banner banner-overlay">
                                                <a href="category.html" class="banner banner-menu">
                                                    <img src="{{ asset('storage/images') }}/components/header/menu/banner-1.jpg" alt="Banner">

                                                    <div class="banner-content banner-content-top">
                                                        <div class="banner-title text-white">Last
                                                            <br>Chance<br><span><strong>Sale</strong></span>
                                                        </div>
                                                        <!-- End .banner-title -->
                                                    </div><!-- End .banner-content -->
                                                </a>
                                            </div><!-- End .banner banner-overlay -->
                                        </div><!-- End .col-md-4 -->
                                    </div><!-- End .row -->
                                </div><!-- End .megamenu megamenu-md -->
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
                        </ul><!-- End .menu -->
                    </nav><!-- End .main-nav -->

                    <button class="mobile-menu-toggler">
                        <span class="sr-only">Toggle mobile menu</span>
                        <i class="icon-bars"></i>
                    </button>
                </div><!-- End .header-left -->

                <div class="header-right">
                    <i class="la la-lightbulb-o"></i>
                    <p>Clearance Up to 30% Off</span></p>
                </div>
            </div><!-- End .container -->
        </div><!-- End .header-bottom -->
    </header><!-- End .header -->