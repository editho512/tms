<style>
    /* Style the button that is used to open and close the collapsible content */
    /*.collapsible {
        background-color: #eee;
        color: #444;
        cursor: pointer;
        padding: 18px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
    }*/
    .collapsible {
        width: 55px;
        cursor: pointer;
        border-radius: 2px;
        height: 55px;
        display: none;
    }
    @media only screen and (max-width: 900px) {
        .collapsible {
            display: block;
        }
        .header-fixed {
            padding-left: 50px!important;
            padding-right: 50px!important;
            display: flex;
            justify-content: space-between;
        }
        .nonable {
            display: none;
        }
    }
    @media only screen and (max-width: 500px) {
        .header-fixed {
            padding-left:10px!important;
            padding-right: 10px!important;
        }
    }
    /* Style the collapsible content. Note: hidden by default */
    .menu {
        padding: 0 18px;
        background-color: white;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.2s ease-out;
        width: 100%;
        margin-top: 80px;
        text-align: left;
        box-shadow: 2px 2px 2px #49aba0;
        opacity: 0.7!important;
    }
</style>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light header-fixed">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <a class="navbar-brand d-flex justify-content-start align-items-center" href="#">
            <img class="img-fluid logo mr-3" src="{{ asset('assets/images/logo/logo.png') }}" alt="">
            <h1 class="header-title">TMS</h1>
        </a>

        @can("viewAny" , auth()->user())
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{route("home")}}" class="nav-link">Dashboard</a>
        </li>
        @endcan
    </ul>

    <ul class="navbar-nav ml-auto nonable">
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
            <a class="nav-link flex" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="fa fa-sign-out-alt mr-3"></i>
                Se deconnecter
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>

    <button style="box-shadow: 1px 1px 1px 1px rgb(97, 97, 97)" type="button" class="collapsible rounded btn btn-info text-center"><i class="fa fa-bars fa-2x"></i></button>

</nav>

<div class="menu">
    <ul class="navbar-nav ml-auto mt-3 mb-3">
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
            <a class="nav-link flex" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="fa fa-sign-out-alt mr-3"></i>
                Se deconnecter
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</div>
<!-- /.navbar -->


<script>
    let coll = document.getElementsByClassName("collapsible")
    let content = document.getElementsByClassName("menu").item(0)
    let i;
    for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            this.classList.toggle("active");
            //let content = this.nextElementSibling;
            if (content.style.maxHeight){
                content.style.maxHeight = null;
            } else {
                content.style.maxHeight = content.scrollHeight + "px";
            }
        });
    }
</script>
