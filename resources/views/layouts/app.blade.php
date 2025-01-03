<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/modern.css" rel="stylesheet">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'SBMS') }}</title>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

  <!-- Scripts -->
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="h-100">
  <div id="app" class="h-100">

    @auth
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
      <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
          {{ config('app.name', 'SBMS') }}
        </a>
        <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
          <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Dark offcanvas</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body">
            <ul class="navbar-nav justify-content-start flex-grow-1 pe-3">
              <li class="nav-item">
                <a class="nav-link {{ Route::is('home') ? 'active' : ''}}" href="{{ route('home')}}">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ Route::is('manageProfile.index') ? 'active' : ''}}" href="{{ route('manageProfile.index') }}">Profile</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ Route::is('manageStock.*') ? 'active' : ''}}" href="{{ route('manageStock.index') }}">Stock</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ Route::is('manageBooking.index') ? 'active' : '' }}" href="{{ route('manageBooking.index') }}">Booking</a>
              </li>
              @if (auth()->user()->role == 'user')
              <li class="nav-item">
                <a class="nav-link {{ Route::is('manageComplaint.index') ? 'active' : ''}}" href="{{ route('manageComplaint.index')}}">Complaint Venue</a>
              </li>
              @endif
              @if (auth()->user()->role == 'admin')
              <li class="nav-item">
                <a class="nav-link {{ Route::is('manageComplaint.adminIndex') ? 'active' : ''}}" href="{{ route('manageComplaint.adminIndex') }}">Complaint</a>
              </li>
              @endif
              @if (auth()->user()->role == 'admin')
              <li class="nav-item">
                <a class="nav-link {{ Route::is('manageLogin.index') ? 'active' : ''}}" href="{{ route('manageLogin.index')}}">Account</a>
              </li>
              @endif
            </ul>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <!-- Right Side Of Navbar -->
              <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                @if (Route::has('login'))
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @endif

                @if (Route::has('register'))
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @endif
                @else
                <li class="nav-item dropdown">
                  <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }}
                  </a>

                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                   document.getElementById('logout-form').submit();">
                      {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                    </form>
                  </div>
                </li>
                @endguest
              </ul>
            </div>
          </div>
    </nav>

    <style>
      .nav-link.active {
        font-weight: bold;
      }
    </style>
    @endauth

    <main class="py-4 h-100">
      @yield('content')
    </main>
  </div>
  <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
  <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  @stack('scripts')
</body>

</html>