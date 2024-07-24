<div class="position-sticky top-0 bg-body-tertiary" style="height: 100vh">
    <div class="d-flex flex-column flex-shrink-0 p-3 h-100" style="width: 280px">
        <a href="{{route('admin.dashboard')}}" class="fs-1 text-decoration-none px-2">
            <img src="{{asset('/storage/images/logo.png')}}" alt="" class="object-fit-contain" style="max-width: 100%; height: 70px">
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 {{$sidebar=='dashboard'?'active':''}}" aria-current="page" href="{{route('admin.dashboard')}}">
                    <i class="fa-solid fa-chart-line"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 {{$sidebar=='catalogue'?'active':''}}" aria-current="page" href="{{route('admin.catalogue.index')}}">
                    <i class="fa-solid fa-list"></i>
                    Catalogue
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 {{$sidebar=='product'?'active':''}}" href="{{route('admin.product.index')}}">
                    <i class="fa-brands fa-product-hunt"></i>
                    Products
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 {{$title=='Customer'?'active':''}}" href="{{route('admin.user.index')}}">
                    <i class="fa-solid fa-users"></i>
                    Users
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 {{$title=='Bill'?'active':''}}" href="{{route('admin.bill.index')}}">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                    Bills
                </a>
            </li>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{Auth::user()->image}}" alt="" width="32" height="32" class="rounded-circle me-2">
                <strong>{{Auth::user()->name}}</strong>
            </a>
            <ul class="dropdown-menu text-small shadow" style="">
                <li><a class="dropdown-item" href="{{asset('profile')}}">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="{{route('logout')}}">Sign out</a></li>
            </ul>
        </div>
    </div>
</div>