<div class="position-sticky top-0 bg-body-tertiary" style="height: 100vh">
    <div class="d-flex flex-column flex-shrink-0 p-3 h-100" style="width: 280px; overflow: auto;">
        <a href="{{route('public.home')}}" class="fs-1 text-decoration-none px-2">
            <img src="{{asset('/storage/images/logo.png')}}" alt="" class="object-fit-contain" style="max-width: 100%; height: 70px">
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 {{$sidebar=='dashboard'?'active':''}}" aria-current="page" href="{{route('admin.dashboard')}}">
                    <i class="fa-solid fa-chart-line"></i>
                    Dashboard
                </a>
            </li>
            <!-- Catalogue -->
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 {{$sidebar=='brand'?'active':''}}" aria-current="page" href="{{route('admin.brand.index')}}">
                <i class="fa-brands fa-ubuntu"></i>
                    Brand
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 {{$sidebar=='catalogue'?'active':''}}" aria-current="page" href="{{route('admin.catalogue.index')}}">
                    <i class="fa-solid fa-list"></i>
                    Catalogue
                </a>
            </li>
            <!-- Product -->
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 {{$sidebar=='product'?'active':''}}" href="{{route('admin.product.index')}}">
                    <i class="fa-brands fa-product-hunt"></i>
                    Products
                </a>
            </li>
            <!-- User -->
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 {{$sidebar=='user'?'active':''}}" href="{{route('admin.user.index')}}">
                    <i class="fa-solid fa-users"></i>
                    Users
                </a>
            </li>
            <!-- Comment -->
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 {{$sidebar=='comment'?'active':''}}" href="{{route('admin.comment.index')}}">
                    <i class="fa-solid fa-comments"></i>
                    Comments
                </a>
            </li>
            <!-- Bill -->
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 {{$sidebar=='bill'?'active':''}}" href="{{route('admin.bill.index')}}">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                    Bills
                </a>
            </li>
            <!-- Voucher -->
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 {{$sidebar=='voucher'?'active':''}}" href="{{route('admin.voucher.index')}}">
                    <i class="fa-solid fa-ticket"></i>
                    Vouchers
                </a>
            </li>
            <!-- Banner -->
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 {{$sidebar=='banner'?'active':''}}" href="{{route('admin.banner.index')}}">
                    <i class="fa-solid fa-images"></i>
                    Banner
                </a>
            </li>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset(Auth::user()->image) }}" alt="" width="32" height="32" class="rounded-circle me-2">
                <strong>{{ Auth::user()->name }}</strong>
            </a>
            <ul class="dropdown-menu text-small shadow">
                <li><a class="dropdown-item" href="{{route('public.profile')}}">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="{{route('logout')}}">Sign out</a></li>
            </ul>
        </div>
    </div>
</div>