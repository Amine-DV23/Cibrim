<!-- Content Start -->

<div class="content">


    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    @auth

        <div class="lgn">

            <!-- Sidebar Start -->
            <div class="sidebar pe-4 pb-3">
                <nav class="navbar bg-secondary navbar-dark">
                    <a href="/home" class="navbar-brand mx-4 mb-3">
                        <h3 class="text-primary">
                            <i class="fa fa-user-edit me-2"></i>CibRim
                        </h3>
                    </a>
                    <div class="navbar-nav w-100">
                        <a href="/home" class="nav-item nav-link active">
                            <i class="fa fa-home me-2"></i>Home
                        </a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fa fa-layer-group me-2"></i>All - Elements
                            </a>
                            <div class="dropdown-menu bg-transparent border-0">
                                <a href="/fournisseurs" class="dropdown-item">
                                    <i class="fa fa-users me-2"></i>fournisseurs
                                </a>
                                <a href="/products" class="dropdown-item">
                                    <i class="fa fa-box me-2"></i>products
                                </a>
                                <a href="/clients" class="dropdown-item">
                                    <i class="fa fa-users me-2"></i>clients
                                </a>

                                <a href="/orders" class="dropdown-item">
                                    <i class="fa fa-shopping-cart me-2"></i>Orders
                                </a>
                            </div>
                        </div>
                        <a href="/fournisseurs" class="nav-item nav-link">
                            <i class="fa fa-user me-2"></i>fournisseurs
                        </a>
                        <a href="/products" class="nav-item nav-link">
                            <i class="fa fa-box me-2"></i>products
                        </a>
                        <a href="/clients" class="nav-item nav-link">
                            <i class="fa fa-users me-2"></i>clients
                        </a>
                        <a href="/orders" class="nav-item nav-link">
                            <i class="fa fa-shopping-cart me-2"></i>Orders
                        </a>

                    </div>

                </nav>
            </div>
            <!-- Sidebar End -->



            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="/index" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
                </a>

                <a href="/#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>

                <div class="navbar-nav align-items-center ms-auto">

                    <div class="nav-item dropdown">
                        <a href="/#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="img/user.jpg" alt=""
                                style="width: 40px; height: 40px;">
                            @auth
                                <span class="d-none d-lg-inline-flex">{{ Auth::user()->name }}</span>
                            @endauth </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">

                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>

                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->
        </div>

    @endauth
