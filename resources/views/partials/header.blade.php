@auth
    <header>
        <div class="menu-toggle" onclick="toggleNav()">
            <i class="fas fa-bars"></i>
        </div>


        <div class="user-info" onclick="toggleUserInfo()">
            <i class="fas fa-user-circle color-icon"></i>
            @auth
                <span>{{ Auth::user()->name }}<i class="fas fa-chevron-down user-arrow"></i></span>
            @endauth
            <div class="logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <span>{{ __('Logout') }}</span>
            </div>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </header>

    <nav class="sidebar">
        <ul>
            <li>
                <a href="/home">
                    <i class="fas fa-home color-icon"></i>
                    <span class="span">Home</span>
                </a>
            </li>

            <li>
                <a href="/products-page">
                    <i class="fas fa-box-open color-icon"></i>
                    <span class="span">Products</span>
                </a>
            </li>

            <li>
                <a href="/clients-Page">
                    <i class="fas fa-user-friends color-icon"></i>
                    <span class="span">Clients</span>
                </a>
            </li>

            <li>
                <a href="/fournisseurs-Page">
                    <i class="fas fa-truck color-icon"></i>
                    <span class="span">Fournisseurs</span>
                </a>
            </li>

            <li>
                <a href="/orders">
                    <i class="fas fa-shopping-cart color-icon"></i>
                    <span class="span">Orders</span>
                </a>
            </li>

            <li class="settings" onclick="toggleSettings()">
                <i class="fas fa-cogs color-icon"></i>
                <span class="span">Settings</span>
                <i class="fas fa-chevron-down settings-icon"></i>
            </li>
            <ul class="settings-dropdown">
                <li><span>Profile </span></li>
                <li><span>Servesr</span></li>
                <li><span>Privacy</span></li>
            </ul>
        </ul>
    </nav>
@endauth
