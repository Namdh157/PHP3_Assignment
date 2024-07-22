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


<!-- <div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary position-sticky top-0" style="height: 100vh;">
    <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">

        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarMenuLabel">Company name</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body d-md-flex flex-column p-0 overflow-y-auto">
            <a href="{{route('admin.dashboard')}}" class="fs-1 text-decoration-none px-2">
                <img src="{{asset('/storage/images/logo.png')}}" alt="" class="object-fit-contain" style="max-width: 100%; height: 70px">
            </a>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 {{$sidebar=='dashboard'?'active':''}}" aria-current="page" href="{{route('admin.dashboard')}}">
                        <svg class="bi">
                            <use xlink:href="#house-fill" />
                        </svg>
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 {{$sidebar=='product'?'active':''}}" href="{{route('admin.product.index')}}">
                        <svg class="bi">
                            <use xlink:href="#cart" />
                        </svg>
                        Products
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 {{$title=='Customer'?'active':''}}" href="{{route('admin.user.index')}}">
                        <svg class="bi">
                            <use xlink:href="#people" />
                        </svg>
                        Customers
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 {{$title=='Bill'?'active':''}}" href="{{route('admin.bill.index')}}">
                        <svg class="bi">
                            <use xlink:href="#file-earmark" />
                        </svg>
                        Orders
                    </a>
                </li>

                <hr class="my-3">

                <ul class="nav flex-column mb-auto">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2" href="#">
                            <svg class="bi">
                                <use xlink:href="#gear-wide-connected" />
                            </svg>
                            Settings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2" href="{{ route('logout') }}">
                            <svg class="bi">
                                <use xlink:href="#door-closed" />
                            </svg>
                            Sign out
                        </a>
                    </li>
                </ul>
        </div>
    </div>
</div> -->