<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light header-fixed">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <a class="navbar-brand" href="#">
            <img class="img-fluid logo" src="{{ asset('assets/images/logo/logo.png') }}" alt="">
        </a>
        <!--li class="nav-item">
            {{-- <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a> --}}
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <img class="img-fluid logo" src="{{ asset('assets/images/logo/logo.png') }}" alt="">
            </a>
        </li-->
        @can("viewAny" , auth()->user())
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{route("home")}}" class="nav-link">Dashboard</a>
            </li>
        @endcan
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a href="{{ route('client.search') }}" class="nav-link @if ($active === 0) active @endif flex">
                <i class="nav-icon fas fa-search mr-3"></i>
                Rechercher transporteurs
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('client.transport.history') }}" class="nav-link  @if ($active === 1) active @endif flex">
                <i class="nav-icon fas fa-list mr-3"></i>
                Mes transports
            </a>
        </li>

        <li class="nav-item">
            <a href="" class="nav-link @if ($active === 2) active @endif flex">
                <i class="nav-icon fas fa-truck mr-3"></i>
                Mes transporteurs favoris
            </a>
        </li>

        <li class="nav-item">
            <a href="" class="nav-link @if ($active === 3) active @endif flex">
                <i class="nav-icon fas fa-wrench mr-3"></i>
                Autres trucs
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link flex" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="fa fa-sign-out-alt mr-3"></i>
                Se deconnecter
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
