<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Old+Standard+TT:ital,wght@0,400;0,700;1,400&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">

    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo/favicon.ico') }}"/>

    <link rel="stylesheet" href="{{asset('assets/login/fonts/icomoon/style.css')}}">

    <link rel="stylesheet" href="{{asset('assets/login/css/owl.carousel.min.css')}}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets/login/css/bootstrap.min.css')}}">

    <!-- Style -->
    <link rel="stylesheet" href="{{asset('assets/login/css/style.css')}}">

    <title>Connexion</title>
</head>

<style>

    *:not(i){
        font-family: 'Montserrat', sans-serif;
        font-weight: 500;
    }

    .title {
        color: #003d6d;
        text-align: center;
    }

    .content {
        padding: 0;
        height: 100vh;
    }

    .container {
        height: 100%;
        display: flex;
        align-content: center;
        justify-content: center;
        align-items: center;
    }

    .form-block {
        width: 100%;
        height: 100%;
    }

    .logo {
        height: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        margin: 0;
        width: 100%;
        margin-bottom: 20px;
    }

    .logo img {
        width: 80px;
        height: auto;
        border-radius: 15px;
        box-shadow: 1px 1px 1px 1px rgb(218, 216, 216);
        padding: 2px;
    }

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
        background-color: #42b0d5;
        border-color: transparent;
        box-shadow: none;
    }

    .button--secondary:hover {
        background-color: #33a1c5;
    }

</style>

<body>
    <div class="content">
        <div class="container">
            <div class="contents">
                {{-- Message d'erreurs --}}
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="form-block">

                    <div class="logo">
                        <img class="img-fluid" src="{{ asset('assets/images/logo/logo.png') }}" alt="" srcset="">
                    </div>

                    <div class="mb-4">
                        <h3 class="title">Connexion sur <strong>{{ config('app.name') }}</strong></h3>
                    </div>
                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="form-group first">
                            <label for="username">Email</label>
                            <input type="text" class="form-control" id="username" name="email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group last mb-4">
                            <label for="password">Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="d-flex mb-5 align-items-center">
                            <label class="control control--checkbox mb-0"><span class="caption">Se souvenir de moi</span>
                                <input type="checkbox" checked="checked"/>
                                <div class="control__indicator"></div>
                            </label>
                            <span class="ml-auto"><a href="#" class="forgot-pass d-none">Mot de passe oublié ?</a></span>
                        </div>

                        <button type="submit" style="float: right;" type="submit" class="button button--secondary">Connexion</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('assets/login/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('assets/login/js/popper.min.js')}}"></script>
    <script src="{{asset('assets/login/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/login/js/main.js')}}"></script>
</body>
</html>
