<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo/favicon.ico') }}"/>

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
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Old+Standard+TT:ital,wght@0,400;0,700;1,400&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
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

        .button {
            font-size: 16px;
            line-height: 24px;
            padding: 7px 19px 9px;
            text-decoration: none;
            display: inline-block;
            vertical-align: top;
            transition: all .2s ease-in-out;
            border: 1px solid transparent;
            border-radius: 5px;
            background-color: #ccc;
            color: #141414;
            cursor: pointer;
            position: relative;
            box-shadow: 2px 2px 2px rgb(114, 114, 114)!important;
        }

        .button--secondary {
            color: #fff;
            background-color: #49aba0;
            border-color: transparent;
            box-shadow: none;
        }

        .color-primary {
            color: #0e6359;
        }

        .button--secondary:hover {
            background-color: #3b9b90;
        }

        .select2-selection__rendered {
            padding: 0!important;
            margin: 0!important;
        }

        .select2-container .select2-selection--single {
            display: flex;
            justify-content: flex-start;
            align-content: center;
            align-items: center;
            height: 40px!important;
        }

        .select2-selection__arrow {
            margin-top: 5px;
        }

        .error {
            border: 1px solid red!important;
            border-radius: 5px!important;
        }

        .modal-footer {
            background-color: hsl(210, 38%, 97%);
        }

        *:not(i){
            font-family: 'Montserrat', sans-serif;
            font-weight: 500;
        }

        .title {
            color: #003d6d;
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
            background-color: #49aba0 !important;
        }
        @media screen and (min-width: 576px) {
            #tableau_bord {
                display: none !important;
            }
        }

        .main-header {
            margin: 0!important;
        }

        .main-footer {
            margin: 0!important;
            width: 100%;
        }

        .flex {
            display: flex!important;
            justify-content: center!important;
            align-items: center!important;
            align-content: center!important;
            transition: all;
            transition-duration: 0.5s;
            color: #003d6d!important;
            font-size: 1.1rem;
        }

        .flex:hover {
            color: #49aba0!important;
        }

        .header-fixed {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            box-shadow: 2px 2px 2px #49aba0;
            opacity: 0,1!important;
            padding-left: 110px;
            padding-right: 110px;
        }

        .logo {
            width: 10%;
            height: auto;
        }

        .active {
            color: #49aba0!important;
        }

        .content-wrapper {
            margin-left: 100px!important;
            margin-right: 100px!important;
            background-color: transparent!important;
        }

        .sidebar-mini {
            background: linear-gradient(to right, hsl(210, 32%, 93%), hsl(0, 54%, 97%))!important;
        }

    </style>

    @yield('styles')

</head>
<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">

        @include('client.header')

        <div id="content" style="margin-top: 15vh; margin-bottom:15vh;">
            @yield('content')
        </div>

        @include('client.footer')

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
