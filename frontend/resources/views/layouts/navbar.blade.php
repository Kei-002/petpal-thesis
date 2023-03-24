<nav class="navbar navbar-expand-lg bg-white sticky-top navbar-light p-3 shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{url('/')}}"><img src="{{ asset('images/pet-shop.png') }}" width="50" height="50"
                alt="petpal logo"> <strong>Pet-Pal</strong></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="mx-auto my-3 d-lg-none d-sm-block d-xs-block">
            <div class="input-group">
                <span class="border-dark input-group-text bg-dark text-dark searchFront"><i
                        class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" class="form-control border-dark searchFront" style="color:#7a7a7a">
                <button class="btn btn-dark text-white searchFront">Search</button>
            </div>
        </div>
        <div class=" collapse navbar-collapse" id="navbarNavDropdown">
            <div class="ms-auto d-none d-lg-block">
                <div class="input-group">
                    <span class="border-dark input-group-text bg-black text-black searchFront"><i
                            class="fa-solid fa-magnifying-glass searchFront"></i></span>
                    <input type="text" class="form-control border-dark searchFront" style="color:#7a7a7a">
                    <button class="btn btn-warning border-dark text-white searchFront">Search</button>
                </div>
            </div>
            <ul class="navbar-nav ms-auto ">
                <li class="nav-item">
                    <a class="nav-link mx-2 text-uppercase" href="{{url('product')}}">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-2 text-uppercase" href="#">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-2 text-uppercase" href="#">Consultations</a> 
                </li>
            </ul>

            
            
            @guest
             <ul class="navbar-nav ms-auto" id="guestLinks">
                <li class="nav-item">
                    <a class="nav-link mx-2 text-uppercase" href="{{url('login')}}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-2 text-uppercase" href="#">Register</a>
                </li>
            </ul>
            @endguest
            @auth
            <ul class="navbar-nav ms-auto " id="userLinks">
                <li class="nav-item">
                    <a class="nav-link mx-2 text-uppercase" href="#"><i class="fa-solid fa-cart-shopping"></i>
                        Cart<span class="badge bg-danger" style="margin-left: 5px"> 4</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link mx-2 text-uppercase dropdown-toggle" data-bs-toggle="dropdown" href="#"
                        role="button" aria-expanded="false"><i class="fa-solid fa-circle-user me-1 "></i>
                        {{Auth::user()->name}}</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        @if(Auth::user()->role !== 'customer')
                        <li><a class="dropdown-item" href="{{url('/dashboard')}}" id="adminLink">Dashboard</a></li>
                        @endif
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#" id="logoutButton">Logout</a></li>
                    </ul>
                </li>
            </ul>
            @endauth
            
        </div>
    </div>
    <script type="text/javascript" charset="utf8" src="{{ asset('js/navbar.js') }}"></script>
</nav>
