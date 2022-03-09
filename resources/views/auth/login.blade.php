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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Connexion</title>
</head>

<style>

    body {
        overflow: hidden;
    }

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
        display: flex;
        justify-content: center;
        align-items: center;
        align-content: center;
    }

    .form-content {
        height: 100%!important;
        width: 30vw;
        padding: 0;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .form {
        width: 100%;
        padding: 50px;
        box-shadow: 2px 2px 12px 2px #0a312cc4;
        border-radius: 5px;
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

    @media only screen and (max-width: 1500px) {
        .form-content {
            width: 40vw;
        }
    }

    @media only screen and (max-width: 1000px) {
        .form-content {
            width: 50vw;
        }
    }

    @media only screen and (max-width: 750px) {
        .form-content {
            width: 80vw;
        }
    }

    @media only screen and (max-width: 470px) {
        .form-content {
            width: 90vw;
        }
    }

    .border-red {
        border-color: red;
    }

    input:focus {
        border-color: rgb(173, 173, 173)!important;
        box-shadow: 2px 2px 2px rgb(185, 185, 185)!important;
        background-color: rgb(226, 226, 226);
    }

</style>

<body>
    <div class="content">
        <div class="form-content">

            <div class="form">

                <div class="logo">
                    <img class="img-fluid" src="{{ asset('assets/images/logo/logo.png') }}" alt="" srcset="">
                </div>

                <div class="mb-4">
                    <h3 class="title">Connexion sur <strong>{{ config('app.name') }}</strong></h3>
                </div>

                <form action="{{ route('login') }}" method="post">

                    @csrf

                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="email"><i class="color-primary fas fa-user"></i></span>
                        </div>
                        <input type="text" name="email" value="{{ old('email') }}" class="form-control @error('email') border-red @enderror" placeholder="Adresse email" aria-label="Email" aria-describedby="email">
                    </div>

                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="password"><i class="color-primary fas fa-lock"></i></span>
                        </div>
                        <input type="password" name="password" class="form-control @error('email') border-red @enderror" placeholder="Mot de passe" aria-label="Password" aria-describedby="password">
                    </div>

                    <div class="d-flex mb-5 align-items-center">
                        <label class="control control--checkbox mb-0"><span class="caption">Se souvenir de moi</span>
                            <input type="checkbox" name="remember" checked="checked"/>
                            <div class="control__indicator"></div>
                        </label>
                        <span class="ml-auto"><a href="#" class="forgot-pass d-none">Mot de passe oublié ?</a></span>
                    </div>
                    <button type="submit" style="float: right;" type="submit" class="button button--secondary"><i class="fa fa-sign-in-alt mr-3"></i>Connexion</button>
                </form>
            </div>
        </div>
    </div>

    <script src="{{asset('assets/login/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('assets/login/js/popper.min.js')}}"></script>
    <script src="{{asset('assets/login/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/login/js/main.js')}}"></script>
</body>
</html>
