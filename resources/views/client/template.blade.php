<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{asset('assets/images/logo/favicon.ico')}}"/>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/adminlte/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="{{asset('assets/adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('assets/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{asset('assets/adminlte/plugins/jqvmap/jqvmap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('assets/adminlte/dist/css/adminlte.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('assets/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('assets/adminlte/plugins/daterangepicker/daterangepicker.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('assets/adminlte/plugins/summernote/summernote-bs4.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <!-- include the style

        <link rel="stylesheet" href="{{asset('assets/alertifyjs/css/alertify.min.css')}}" />
    -->
    <!-- include a theme
        <link rel="stylesheet" href="{{asset('assets/alertifyjs/css/themes/default.min.css')}}" />
    -->
    <!-- include the script
        <script src="{{asset('assets/alertifyjs/alertify.min.js')}}"></script>
    -->

    <!-- JavaScript -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>

    <style>
        .modal-footer{
            background: rgba(0,0,0,.03);
        }

        .modal-header-success {
            background: #28a745;
            color: white;
        }

        .modal-header-primary {
            background: #007bff;
            color: white;
        }

        .modal-header-danger {
            background: #dc3545;
            color: white;
        }

        .font-xx-large {
            font-size: xx-large;
        }

        .font-x-large {
            font-size: x-large;
        }

        .card-header-success {
            background: #28a745;
            color: white;
        }

        .card-header-danger {
            background: #dc3545;
            color: white;
        }

        .card-header-info {
            background: #17a2b8 linear-gradient(180deg,#3ab0c3,#17a2b8) repeat-x !important;
            color: white;
        }

        .has-treeview > .active{
            background-color: #3490c1 !important;
        }
        @media screen and (min-width: 576px) {
            #tableau_bord {
                display: none !important;
            }
        }
    </style>

    @yield('styles')

</head>
<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">

        @include('layouts.header')

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #023047">
            <!-- Brand Logo -->
            <a href="" class="brand-link">
                <img src="{{asset('assets/images/logo/logo-tsaravidy.jpg')}}" alt="Tsaravidy Logo" class="brand-image img-circle elevation-3"
                style="opacity: .8">
                <span class="brand-text font-weight-light">{{ config('app.name') }} V1.0</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar" >
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{asset('assets/images/avatars/avatar.png')}}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{Auth::user()->name}}</a>
                    </div>
                </div>
                <div class="user-panel  d-flex" id="tableau_bord" style="">
                    <a style="@if(isset($active_dashboard_index))  color:white !important; @endif" href="" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i>&nbsp;&nbsp;Dashboard</a>
                </div>
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item has-treeview">
                            <a href="{{ route('client.search') }}" class="nav-link @if ($active === 0) active @endif">
                                <i class="nav-icon fas fa-search"></i>
                                <p>Rechercher transporteurs</p>
                            </a>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="{{ route('client.transport.history') }}" class="nav-link  @if ($active === 1) active @endif">
                                <i class="nav-icon fas fa-list"></i>
                                <p>Mes transports</p>
                            </a>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="" class="nav-link @if ($active === 2) active @endif">
                                <i class="nav-icon fas fa-truck"></i>
                                <p>Mes transporteurs favoris</p>
                            </a>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="" class="nav-link @if ($active === 3) active @endif">
                                <i class="nav-icon fas fa-wrench"></i>
                                <p>Autres trucs</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <div id="content">
            @yield('content')
        </div>

        @include('layouts.footer')

    </div>
    <!-- ./wrapper -->

    @yield('modals')


    <!-- jQuery -->
    <script src="{{asset('assets/adminlte/plugins/jquery/jquery.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{asset('assets/adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- ChartJS -->
    <script src="{{asset('assets/adminlte/plugins/chart.js/Chart.min.js')}}"></script>
    <!-- Sparkline -->
    <script src="{{asset('assets/adminlte/plugins/sparklines/sparkline.js')}}"></script>
    <!-- JQVMap -->
    <script src="{{asset('assets/adminlte/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
    <script src="{{asset('assets/adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{asset('assets/adminlte/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
    <!-- daterangepicker -->
    {{--<script src="{{asset('assets/adminlte/plugins/moment/moment.min.js')}}"></script>--}}
    <script src="{{asset('assets/adminlte/plugins/moment/moment-with-locales.js')}}"></script>
    <script src="{{asset('assets/adminlte/plugins/daterangepicker/daterangepicker.js')}}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{asset('assets/adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <!-- Summernote -->
    <script src="{{asset('assets/adminlte/plugins/summernote/summernote-bs4.min.js')}}"></script>
    <!-- overlayScrollbars -->
    <script src="{{asset('assets/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('assets/adminlte/dist/js/adminlte.js')}}"></script>

    @php
    $notification = Session::has("notification") === true ? Session::get("notification") : null;
    Session::forget("notification");
    @endphp
    @if (isset($notification) === true && $notification != null)
    <script>
        $(document).ready(function () {
            let notif = {
                status : "{{$notification['status']}}" ,
                value :  "{{$notification['value']}}"
            }

            alertify.set('notifier','position', 'bottom-right');
            if(notif.status == "success"){
                alertify.success(notif.value);
            }else{
                alertify.error(notif.value);
            }
        })

    </script>

    @endif
    @yield('scripts')

</body>
</html>
