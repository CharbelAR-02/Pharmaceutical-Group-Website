<nav class="navbar navbar-expand-lg navbar-light fixed-nav" style="background-color: #FFFACD;">
    <div class="container-fluid">
        <a style="color: #000;" class="navbar-brand" href="{{ route('home') }}">PharmaGroup</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
            aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarText">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a style="color: #000;" class="{{ Route::is('home') ? 'active-link' : '' }} nav-link"
                        aria-current="page" href="{{ route('home') }}">Home</a>
                </li>
                @guest
                    <li class="nav-item">
                        <a style="color: #000;" class="{{ Route::is('login') ? 'active-link' : '' }} nav-link"
                            href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a style="color: #000;" class="{{ Route::is('register') ? 'active-link' : '' }} nav-link"
                            href="{{ route('register') }}">Register</a>
                    </li>
                @endguest

                <li class="nav-item">
                    <a style="color: #000;" class="{{ Route::is('medications') ? 'active-link' : '' }} nav-link"
                        aria-current="page" href="{{ route('medications') }}">Products</a>
                </li>
                @auth
                    <li class="nav-item dropdown">
                        <a style="color: #000" class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                        </a>
                        <ul class="dropdown-menu text-center dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" style="color: #000"
                                    @if (Auth::user()->role === 'special_employe') href="{{ route('specialEmploye', ['id' => Auth::user()->id]) }}">Profile</a></li> @endif
                                    @if (Auth::user()->role === 'customer') href="{{ route('Customer', ['id' => Auth::user()->id]) }}">Profile</a></li> @endif
                                    @if (Auth::user()->role === 'pharmacist') href="{{ route('Customer', ['id' => Auth::user()->id]) }}">Profile</a></li> @endif
                                    <li class="nav-item">
                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <button class="btn btn-danger btn-sm text-center" type="submit">Logout</button>
                                    </form>
                            </li>

                        </ul>
                    </li>

                @endauth
            </ul>
        </div>
    </div>
</nav>
<style>
    .active-link {
        background-color: #E5F2F7;
        /* Light blue background color */
        color: #000;
        /* Black text color */
        border-radius: 10px;
        /* Rounded corners if desired */
    }

    .fixed-nav {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;

    }
</style>
