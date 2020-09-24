<?php
use App\DataLayer;
$dl = new \App\DataLayer();
$recipes_all = $dl->getAllRecipeAZ();

$recipes = array();
foreach ($recipes_all as $recipe_ok) {
    if($recipe_ok->approved == 1 || $recipe_ok->approved == 3){
        array_push($recipes, $recipe_ok);
    }
}

$recipes_allDate= $dl->getAllRecipeDate();

$recipesDate = array();
foreach ($recipes_allDate as $recipe_okDate) {
    if($recipe_okDate->approved == 1 || $recipe_okDate->approved == 3){
        array_push($recipesDate, $recipe_okDate);
    }
}


?>

@extends('utils.base_page')

@section('title', 'ChatChef')

@section('right_navbar')
    @if($logged)
        <li class="nav-item pr-2 pb-1">
            <img style="border-radius: 100px; height: 40px; width: 40px;"
                 @if(($dl->getUserbyUsername($loggedName))->image_profile == NULL)
                 src="{{asset('image/default_user/paw.jpg')}}"
                 @else
                 src ="{{asset(($dl->getUserbyUsername($loggedName))->image_profile)}}"
                @endif
            >
        </li>
        <li class="nav-item">
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle " type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ $loggedName }}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @include('utils.rightnavbar', ['active'=>"0"])
                    <a class="dropdown-item" href="{{route('logout')}}">@lang('labels.logout')</a>
                </div>
            </div>
        </li>
    @else
        <li class="nav-item">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginRegModal">
                @lang('labels.loginButton')
            </button>
        </li>
    @endif
@endsection

@section('body')



    <div id="parent-title" class="container text-center p-4">
        <img src="{{asset('image/doodle/doodle1.jpg')}}" width="200" height="60" alt="">

        <div class="d-flex justify-content-center">
            <div class="row  align-self-center pr-4">
                <lottie-player id="fir-lottie"
                               src="{{asset('/icons/angry-cat.json')}}"
                               background="transparent"
                               speed="1"
                               style="width: 50px; height: 50px;position: relative;"

                >
                </lottie-player>
                <script>
                    var fir_animation = document.getElementById("fir-lottie");
                    $("#parent-title").mouseover(function () {
                        fir_animation.play();
                    });
                    $("#parent-title").mouseleave(function () {
                        fir_animation.stop();
                    });
                </script>

            </div>
            <h1 class="h-title">ChatChef</h1>
            <div class="row align-self-center pl-4">
                <lottie-player id="sec-lottie"
                               src="{{asset('/icons/salad.json')}}"
                               background="transparent"
                               speed="1"
                               style="width: 50px; height: 50px;"

                >
                </lottie-player>
                <script>
                    var sec_animation = document.getElementById("sec-lottie");
                    $("#parent-title").mouseover(function () {
                        sec_animation.play();
                    });
                    $("#parent-title").mouseleave(function () {
                        sec_animation.stop();
                    });
                </script>

            </div>
        </div>

        <img src="{{asset('image/doodle/doodle2.jpg')}}" width="200" height="60" alt="">
    </div>

    <!-- Copertina -->
    <div class="image-container">
        <div id="cover">

        </div>

        <script src="{{asset('js/helloCovers.js')}}"></script>
    </div>


    <div class="container text-center pt-4 pb-4">
        <div class="d-flex justify-content-center">
            <div id="click" onclick="fadeAZ()" class="row  align-self-center pr-5">
                <lottie-player background="transparent"
                               hover
                               id="az-lottie"
                               speed="1"
                               src="{{asset('/icons/AZ.json')}}"
                               style="width: 50px; height: 50px;position: relative;"

                >
                </lottie-player>
            </div>
            <script>


                function fadeAZ() {
                    document.getElementById("date").hidden = true;
                    document.getElementById("dateI").hidden = true;

                        if(document.getElementById("AZ").hidden) {
                            $(document.getElementById("ZA")).fadeOut();
                            document.getElementById("AZ").hidden = false;
                            $(document.getElementById("AZ")).fadeIn();
                            document.getElementById("ZA").hidden = true;

                        }
                        else{
                            $(document.getElementById("AZ")).fadeOut();
                            document.getElementById("ZA").hidden = false;
                            $(document.getElementById("ZA")).fadeIn();
                            document.getElementById("AZ").hidden = true;
                        }



                }

            </script>
            <h3 class="h-title">
                @lang('labels.homeTitle')
            </h3>
            <div onclick="fadeDate()" class="row align-self-center pl-5">
                <lottie-player id="date-lottie"
                               src="{{asset('/icons/calendar.json')}}"
                               background="transparent"
                               speed="1"
                               hover
                               style="width: 50px; height: 50px;"

                >
                </lottie-player>
                <script>

                    function fadeDate() {
                        document.getElementById("ZA").hidden = true;
                        document.getElementById("AZ").hidden = true;

                        if(document.getElementById("date").hidden) {
                            $(document.getElementById("dateI")).fadeOut();
                            document.getElementById("date").hidden = false;
                            $(document.getElementById("date")).fadeIn();
                            document.getElementById("dateI").hidden = true;
                        }
                        else{
                            $(document.getElementById("date")).fadeOut();
                            document.getElementById("dateI").hidden = false;
                            $(document.getElementById("dateI")).fadeIn();
                            document.getElementById("date").hidden = true;
                        }


                    }

                </script>

            </div>
        </div>
        <img src="{{asset('image/doodle/doodle6.jpg')}}" width="250" height="60" alt="">

    </div>



    <!-- Card recipes IDate-->
    <div id="fade" class="container">
        <div id="AZ" class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3">
            @foreach($recipes as $recipe)

                    @include('utils.card_view_recipe_home',['recipe'=>$recipe])

            @endforeach
        </div>
        <div id="ZA" hidden class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3">
            @foreach(array_reverse($recipes) as $recipeZA)

                    @include('utils.card_view_recipe_home',['recipe'=>$recipeZA])

            @endforeach
        </div>
        <div id="date" hidden class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3">
            @foreach( $recipesDate as $recipeDate)

                @include('utils.card_view_recipe_home',['recipe'=>$recipeDate])

            @endforeach
        </div>
        <div id="dateI" hidden class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3">
            @foreach(array_reverse($recipesDate) as $recipeDateI)

                @include('utils.card_view_recipe_home',['recipe'=>$recipeDateI])

            @endforeach
        </div>

    </div>




    <script type="text/javascript">
        $(window).load(function () {
            $('.post-module').hover(function () {
                $(this).find('.description').stop().animate({
                    height: "toggle",
                    opacity: "toggle"
                }, 300);
            });
        });
    </script>

@endsection
