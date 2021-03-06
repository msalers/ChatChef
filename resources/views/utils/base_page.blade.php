<?php
use App\DataLayer;
$dl = new \App\DataLayer();


?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title> @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSS -->
    <!-- style.css -->
    <link href="{{url('/css/bootstrap.css')}}" rel="stylesheet" type="text/css" >
    <link href="{{url('/css/style.css')}}" rel="stylesheet" type="text/css" >
{{--    <link href="{{url('/Cirrus-0.6.0/dist/cirrus.css')}}" rel="stylesheet" type="text/css" >--}}


   <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@700&display=swap" rel="stylesheet">
    <!-- bootstrap -->
{{--    <link rel="stylesheet" href="{{url('css/bootstrap.css')}}">--}}
    <!-- OwlCarousel -->
    <link rel="stylesheet" href="{{url('/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{url('/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css')}}">
    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Sacramento&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Satisfy&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fredericka+the+Great&display=swap" rel="stylesheet">
    <!-- fontawesome -->
    <link rel="stylesheet" href="{{url('/fontawesome-free-5.15.1-web/css/all.css')}}">
    <!-- line awsome -->
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <!-- JS -->
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- popper.min.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <!-- bootstrap.min.js -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <!-- md5 -->
    <script src="{{url('/js/md5.js')}}"></script>
    <!-- OwlCarousel -->
    <script src="{{url('/OwlCarousel2-2.3.4/dist/owl.carousel.js')}}"></script>





</head>
<body >

    <nav class="navbar navbar-expand-md navbar-light bg-light" id="nav_parent">

        <div class="row m-0 w-100">
            <div class="col-6 col-md-3 order-1">
                <a class="navbar-brand d-inline-flex align-items-center " href="{{route('home')}}">
            <lottie-player id="nav-lottie"
                           src="{{asset('/icons/maneki.json')}}"
                           background="transparent"
                           speed="1"
                           style="width: 40px; height: 40px;">
            </lottie-player>
            @lang('labels.allRecipes')

            <script>
                var nav_animation = document.getElementById("nav-lottie");
                $("#nav_parent").mouseover(function () {
                    nav_animation.play();
                });
                $("#nav_parent").mouseleave(function () {
                    nav_animation.stop();
                });
            </script>
        </a>
            </div>

            <div class="col-12 col-md-6 d-flex justify-content-center order-3 order-md-2">
                <form class="form-inline flex-nowrap w-100" action="{{ route('search_simple') }}" method="post">
                    @csrf

                    <div class="input-group flex-fill">
                        <input class="searcher form-control" name="text" placeholder="@lang('labels.searchPlaceholder') una ricetta"  aria-label="Search">

                        <div class="input-group-append">
                        </div>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="bottom" title="@lang('labels.searchPlaceholder')">
                                {{--                            @lang('labels.advancedsearch')--}}
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <a class="btn btn-outline-secondary ml-1" href="{{route('search')}}" data-toggle="tooltip" data-placement="bottom" title="@lang('labels.advancedsearch')">
                        Ricerca Avanzata
                        <i class="fas fa-sliders-h"></i>
                    </a>
                    <script>
                        $(function () {
                            $('[data-toggle="tooltip"]').tooltip()
                        })
                    </script>
                </form>

                <div class="tendina w-100 px-4">
                    <ul class="list-group suggestions">

                    </ul>
                </div>

                <script type="text/javascript">

                    let recipes = <?php echo json_encode($recipes) ?>;

                    const searchInput = document.querySelector('.searcher');
                    const suggestionPanel = document.querySelector('.suggestions');

                    searchInput.addEventListener("keyup", function () {
                        const input = searchInput.value.toString().toUpperCase();

                        suggestionPanel.innerHTML = '';
                        const suggestions = recipes.filter(function (recipe) {
                            return recipe.title.toUpperCase().includes(input);
                        });

                        suggestions.forEach(function (suggested) {

                            let a = $('<a href="/recipe_view/' + suggested.id + '">' + suggested.title + '</a>')

                            let li = $('<li></li>').addClass('list-group-item');

                            li.append(a);

                            $(suggestionPanel).append(li);

                            // div.innerHTML = "<li class='pt-2 pb-2'><a href='/recipe_view/" + suggested.id + "'>" + suggested.title + "</a></li>";
                            //
                            // suggestionPanel.appendChild(div);
                        });

                        if (input == '') {
                            suggestionPanel.innerHTML = '';
                        }

                    });
                </script>
            </div>

            <div class="col-6 col-md-3 d-flex justify-content-end align-items-center flex-nowrap order-2 order-md-3">

                    @if($logged)
                        <ul class="navbar-nav mr-2">
                        <li class="nav-item">
                            <a class="nav-link disabled" href="{{route('logout')}}">{{ $loggedName }}</a>
                        </li>
                        </ul>
                        <img style="height: 40px; width: 40px; border-radius: 100px; border-style: solid; border-width: thin"
                             @if(($dl->getUserbyUsername($loggedName))->image_profile == NULL)
                             src="{{asset('image/default_user/paw.jpg')}}"
                             @else
                             src ="{{asset(($dl->getUserbyUsername($loggedName))->image_profile)}}"
                            @endif
                        >
                    @else

                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginRegModal">
                            @lang('labels.loginButton')
                        </button>

                    @endif
                    {{--            @yield('right_navbar')--}}

            </div>
        </div>

    </nav>

    {{--    Barra di navigazione secondaria--}}
    @if($logged)
    <nav class="navbar navbar-expand-md navbar-light bg-light sticky-top align-content-center border-top border-bottom">
        <ul class="navbar-nav">
            <li class="navbar-text">
                Il mio Account
            </li>
        </ul>
        <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbar2NavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
             <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar2NavDropdown">
        <ul class="navbar-nav ml-sm-auto">
            <li class="nav-item">
                <a class="nav-link" id="navbar2-insertrecipe" href="{{route('insert')}}">
                    <i class="fas fa-feather-alt"></i>
                    Inserisci una ricetta
                </a>
            </li>
            <li class="nav-item border-left"></li>
            <li class="nav-item">
                <a class="nav-link" id="navbar2-myrecipes" href="{{route('account_all_recipes')}}">
                    <i class="far fa-file-alt"></i>
                    @lang('labels.recipeAll')
                </a>
            </li>
            <li class="nav-item border-left"></li>
            <li class="nav-item">
                <a class="nav-link" id="navbar2-favorites" href="{{route('account_favorites')}}">
                    <i class="far fa-heart"></i>
                    @lang('labels.recipeFav')
                </a>
            </li>
            <li class="nav-item border-left"></li>
            <?php $user = ($dl->getUserbyUsername($loggedName)); ?>
            @if($user->isEditor)
                <li class="nav-item">
                    <a class="nav-link" id="navbar2-recentlyadded" href="{{route('review')}}">
                        <i class="fas fa-history"></i>
                        @lang('labels.recentlyAdded')
                    </a>
                </li>
            @endif
            @if($user->isModerator)
                <li class="nav-item">
                    <a class="nav-link" id="navbar2-revised" href="{{route('approved')}}">
                        <i class="fas fa-tasks"></i>
                        @lang('labels.revised')
                    </a>
                </li>
            @endif
            @if($user->isAdmin)
                <li class="nav-item">
                    <a class="nav-link" id="navbar2-accounts" href="{{route('account_management')}}">
                        <i class="fas fa-users"></i>
                        @lang('labels.accountManagement')
                    </a>
                </li>
            @endif
            <li class="nav-item border-left"></li>
            <li class="nav-item">
                <a class="nav-link" id="navbar2-settings" href="{{route('account_settings')}}">
                    <i class="fas fa-cogs"></i>
                    @lang('labels.settings')
                </a>
            </li>
            <li>

                <a class="nav-link btn btn-danger" id="navbar2-logout" style="color: white" href="{{route('logout')}}">
                    <i class="fas fa-sign-out-alt"></i>
                    @lang('labels.logout')
                </a>
            </li>
        </ul>
        </div>

    </nav>
    @endif



   <!-- Modal form -->
    <div class="modal fade" id="loginRegModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                    <div class="container">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-login-tab" data-toggle="tab" href="#login"
                                   role="tab" aria-controls="login" aria-selected="true">@lang('labels.logInModaltab')</a>
                                <a class="nav-item nav-link" id="nav-register-tab" data-toggle="tab" href="#register"
                                   role="tab" aria-controls="register" aria-selected="false">@lang('labels.registerModaltab')</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <br/>
                            <div class="tab-pane fade show active" id="login" role="tabpanel"
                                 aria-labelledby="nav-login-tab">

                                <script>
                                    function validateFormLogin() {
                                        var username = document.forms['login_form']['username'].value;
                                        var password = document.forms['login_form']['password'].value;

                                        var auth = 1;
                                        var token = '{{\Illuminate\Support\Facades\Session::token()}}';

                                        var urlAuth = '{{route('auth')}}';

                                        $.ajax({
                                            method: 'POST',
                                            url: urlAuth,
                                            data: {username: username, password: password, _token: token},
                                            async: false,
                                            success: function(response){
                                                auth = response ;
                                            }
                                        });

                                        if (auth != 1) {
{{--                                            @if(session()->has('language'))--}}

{{--                                                @if(session('language') == "it")--}}
{{--                                                    swal("C'è un errore!", "Il nome utente o la password sono sbagliati.", "error");--}}
{{--                                                    return false;--}}
{{--                                                @elseif (session('language') == "en")--}}
{{--                                                    swal("There is an error!", "The username or the password is wrong.", "error");--}}
{{--                                                    return false;--}}

{{--                                                @endif--}}
{{--                                            @else--}}
                                                swal("C'è un errore!", "Il nome utente o la password sono sbagliati.", "error");
                                                return false;
{{--                                            @endif--}}


                                        }
                                    }
                                </script>


                                <form id="login_form" onsubmit="return validateFormLogin()"
                                      action="{{ route('login') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="username">@lang('labels.modalLoginUsername')</label>
                                        <input required type="username" class="form-control" name="username">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <div class="input-group" id="show_hide_password">
                                            <input required type="password" class="form-control" data-toggle="password" name="password">
                                            <div class="input-group-append">
                                                <a class="input-group-text"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    $("#show_hide_password a").on('click', function(event) {
                                                        event.preventDefault();
                                                        if($('#show_hide_password input').attr("type") == "text"){
                                                            $('#show_hide_password input').attr('type', 'password');
                                                            $('#show_hide_password i').addClass( "fa-eye-slash" );
                                                            $('#show_hide_password i').removeClass( "fa-eye" );
                                                        }else if($('#show_hide_password input').attr("type") == "password"){
                                                            $('#show_hide_password input').attr('type', 'text');
                                                            $('#show_hide_password i').removeClass( "fa-eye-slash" );
                                                            $('#show_hide_password i').addClass( "fa-eye" );
                                                        }
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </div>


                                    <div class="form-group pt-2">
                                        <div class="container text-center col-sm-4">
                                            <input type="submit" name="login-submit"
                                                   class="form-control btn btn-outline-primary" value=@lang('labels.loginButton')>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="text-center">
                                            <a href="{{route('forgot')}}">@lang('labels.modalLoginForgot')</a>
                                        </div>
                                    </div>
                                </form>


                            </div>
                            <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="nav-register-tab">

                                <script>
                                    function validateForm() {
                                        var username = document.forms['register_form']['username'].value;
                                        var password = document.forms['register_form']['password'].value;
                                        var confirmPassword = document.forms['register_form']['confirm-password'].value;

                                        var thereis = 1;
                                        var token = '{{\Illuminate\Support\Facades\Session::token()}}';

                                        var urlUser = '{{route('thereIs')}}';

                                        $.ajax({
                                            method: 'POST',
                                            url: urlUser,
                                            data: {username: username, _token: token},
                                            async: false,
                                            success: function(response){
                                                thereis = response ;
                                            }
                                        });

                                        if (thereis == 1 ) {
{{--                                            @if(session()->has('language'))--}}

{{--                                                @if(session('language') == "it")--}}
{{--                                                    swal("Controlla il nome utente!", "Questo nome utente è già stato utilizzato.", "error");--}}
{{--                                                    return false;--}}
{{--                                                @elseif (session('language') == "en")--}}
{{--                                                    swal("Check the username!", "This username was already taken.", "error");--}}
{{--                                                    return false;--}}

{{--                                                @endif--}}
{{--                                            @else--}}
                                                swal("Controlla il nome utente!", "Questo nome utente è già stato utilizzato.", "error");
                                                    return false;
{{--                                            @endif--}}

                                        }


                                        if (password !== confirmPassword) {
{{--                                            @if(session()->has('language'))--}}

{{--                                                @if(session('language') == "it")--}}
{{--                                                    swal("Controlla la password!", "Le password non coincidono.", "error");--}}
{{--                                                    return false;--}}
{{--                                                @elseif (session('language') == "en")--}}
{{--                                                    swal("Check the password!", "Passwords do not match.", "error");--}}
{{--                                                    return false;--}}
{{--                                                @endif--}}
{{--                                            @else--}}
                                                swal("Controlla la password!", "Le password non coincidono.", "error");
                                                    return false;
{{--                                            @endif--}}

                                        }
                                        return true;
                                    }
                                </script>


                                <form id="register_form" onsubmit="return validateForm()" action="{{route('register')}}"
                                      method="post">
                                    @csrf
                                    <p style="color: grey">@lang('messages.asteriskIsMandatory')</p>
                                    <div class="form-group">
                                        <label for="username">@lang('labels.modalLoginUsername')*</label>
                                        <input required type="text" class="form-control" name="username">
                                    </div>
                                    <div class="form-group">
                                        <label for="firstname">@lang('labels.modalRegFirstname')*</label>
                                        <input required type="text" class="form-control" name="firstname">
                                    </div>
                                    <div class="form-group">
                                        <label for="lastname">@lang('labels.modalRegLastname')*</label>
                                        <input required type="text" class="form-control" name="lastname">
                                    </div>
                                    <div class="form-group">
                                        <label for="birthday">@lang('labels.modalRegBirthday')</label>
                                        <input type="date" class="form-control" name="birthday">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">@lang('labels.modalRegEmail')*</label>
                                        <input required type="email" class="form-control" name="email">
                                    </div>
                                    <div id="insert_password" class="form-group">
                                        <label for="password">Password*</label>
                                        <div class="input-group" id="insert_password">
                                            <input required type="password" class="form-control" name="password">
                                            <div class="input-group-append">
                                                <a class="input-group-text"><i class="fa fa-eye-slash"
                                                                               aria-hidden="true"></i></a>
                                            </div>
                                            <script>
                                                $(document).ready(function () {
                                                    $("#insert_password a").on('click', function (event) {
                                                        event.preventDefault();
                                                        if ($('#insert_password input').attr("type") == "text") {
                                                            $('#insert_password input').attr('type', 'password');
                                                            $('#insert_password i').addClass("fa-eye-slash");
                                                            $('#insert_password i').removeClass("fa-eye");
                                                        } else if ($('#insert_password input').attr("type") == "password") {
                                                            $('#insert_password input').attr('type', 'text');
                                                            $('#insert_password i').removeClass("fa-eye-slash");
                                                            $('#insert_password i').addClass("fa-eye");
                                                        }
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirm-password">@lang('labels.modalRegConfimPassword')*</label>
                                        <div class="input-group" id="check_password">
                                            <input required type="password" class="form-control"
                                                   name="confirm-password">
                                            <div class="input-group-append">
                                                <a class="input-group-text"><i class="fa fa-eye-slash"
                                                                               aria-hidden="true"></i></a>
                                            </div>
                                            <script>
                                                $(document).ready(function () {
                                                    $("#check_password a").on('click', function (event) {
                                                        event.preventDefault();
                                                        if ($('#check_password input').attr("type") == "text") {
                                                            $('#check_password input').attr('type', 'password');
                                                            $('#check_password i').addClass("fa-eye-slash");
                                                            $('#check_password i').removeClass("fa-eye");
                                                        } else if ($('#check_password input').attr("type") == "password") {
                                                            $('#check_password input').attr('type', 'text');
                                                            $('#check_password i').removeClass("fa-eye-slash");
                                                            $('#check_password i').addClass("fa-eye");
                                                        }
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="container text-center col-sm-4">
                                            <input type="submit" name="register-submit"
                                                   class="form-control btn btn-outline-primary" value=@lang('labels.registerModaltab')>
                                        </div>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>


    @yield('body')


    <div class="footer">


        <div class="container">

            {{--<div class="dropdown">
            Lingua:
            @if(session()->has('language') && session('language') == "en")
                    <button class="btn btn-outline-secondary-my dropdown-toggle" type="button"
                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                        <a class="dropdown-item" href="{{route('setLang',['lang'=>'en'])}}"><img
                                src="{{asset('image/flags/uk.jpg')}}" class="flag-icon"> English</a>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{route('setLang',['lang'=>'it'])}}"><img
                                src="{{asset('image/flags/it.jpg')}}" class="flag-icon"> Italiano</a>

                    </div>
                @else
                    <button class="btn btn-outline-secondary-my dropdown-toggle" type="button"
                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                        <a href="{{route('setLang',['lang'=>'it'])}}"><img
                                src="{{asset('image/flags/it.jpg')}}" class="flag-icon"> Italiano</a>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{route('setLang',['lang'=>'en'])}}"><img
                                src="{{asset('image/flags/uk.jpg')}}" class="flag-icon"> English</a>

                    </div>
                @endif
        </div>--}}

        </div>

        <div class="text-center small">
            <br/>
            <p>@lang('labels.designBy')</p>
            <a href="{{route('credits')}}">@lang('labels.creditsLink')</a>
        </div>
    </div>


    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="//cdn.loop11.com/embed.js" type="text/javascript" async="async"></script>
</body>
</html>
