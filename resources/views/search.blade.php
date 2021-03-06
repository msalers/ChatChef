<?php

use App\DataLayer;

$dl = new \App\DataLayer();
$recipes_all = $dl->getAllRecipe();

$recipes = array();
foreach ($recipes_all as $recipe_ok) {
    if ($recipe_ok->approved == 1 || $recipe_ok->approved == 3) {
        array_push($recipes, $recipe_ok);
    }
}

$list_ingredients = $dl->getAllIngredients();

$list_tags = array();
$list_tags_en = array("1" => "First dish", "2" => "Main", "3" => "Dessert", "4" => "Appetizer", "5" => "Side dish", "6" => "Meat", "7" => "Fish", "8" => "Vegetarian", "9" => "Vegan", "10" => "Gluten Free", "11" => "Without allergens");
$list_tags_it = array("1" => "Primo", "2" => "Secondo", "3" => "Dolce", "4" => "Antipasto", "5" => "Contorno", "6" => "Carne", "7" => "Pesce", "8" => "Vegetariano", "9" => "Vegano", "10" => "Senza glutine", "11" => "Senza allergeni");


if (session()->has('language')) {
    if (session('language') == "it") {
        $list_tags = $list_tags_it;
    } elseif (session('language') == "en") {
        $list_tags = $list_tags_en;
    }
} else {
    $list_tags = $list_tags_it;
}

$users = $dl->getAllUsername();


?>

@extends('utils.base_page')

@section('title', 'Advanced search')


@section('right_navbar')
    @if($logged)
        <li class="nav-item pr-2 pb-1">
            <img style="border-radius: 100px; height: 40px; width: 40px;"
                 @if(($dl->getUserbyUsername($loggedName))->image_profile == NULL)
                 src="{{asset('image/default_user/paw.jpg')}}"
                 @else
                 src="{{asset(($dl->getUserbyUsername($loggedName))->image_profile)}}"
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

    {{--

        <!-- Header -->
        <div id="parent-title" class="container text-center p-4">
            <img src="{{asset('image/doodle/doodle10.jpg')}}" width="350" height="60">
            <div class="d-flex justify-content-center">
                <div class="row  align-self-center pr-4">
                    <lottie-player id="fir-lottie"
                                   src="{{asset('/icons/light-on.json')}}"
                                   background="transparent"
                                   speed="1"
                                   style="width: 50px; height: 50px;position: relative;"

                    >
                    </lottie-player>
                    <script>
                        var fir_animation = document.getElementById("fir-lottie");
                        $("#parent-title").mouseover(function () {
                            fir_animation.play();
                            ààà
                        });
                        $("#parent-title").mouseleave(function () {
                            fir_animation.stop();
                        });

                    </script>

                </div>
                <h1 class="h-title">
                    @lang('labels.advancedsearch')
                </h1>
                <div class="row align-self-center pl-4">
                    <lottie-player id="sec-lottie"
                                   src="{{asset('/icons/searching.json')}}"
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

            <img src="{{asset('image/doodle/doodle10.jpg')}}" width="350" height="60">
        </div>

        <div class="container col-lg-6 col-md-8 col-sm-12">
            <div class="card border-info">
                <div class="card-body">
                    @lang('labels.advanceSearchdescription')
                </div>
            </div>
        </div>

        <form action="{{route('search_advanced')}}" method="post">
            @csrf
            <div class="container text-center p-4">
                <p style="font-family: 'Amatic SC', cursive; font-size: 40px">
                    @lang('labels.chooseMethodSearch')
                </p>
            </div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="custom-control custom-switch custom-control-inline">
                                    <span class="pr-5">@lang('labels.atleast')</span>
                                    <input type="checkbox" class="custom-control-input" name="method__research__toggle"
                                           id="customSwitch1">
                                    <label class="custom-control-label"
                                           for="customSwitch1">@lang('labels.everything')</label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Ingredients checkboxes-->
            <div class="container text-center p-4">
                <p style="font-family: 'Amatic SC', cursive; font-size: 40px">
                    @lang('labels.chooseIngredients')
                </p>
            </div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                @foreach($list_ingredients as $item)
                                    <div class="custom-control custom-control-inline custom-checkbox mb-2">
                                        <input type="checkbox" class="custom-control-input" name="{{$item}}" id="{{$item}}">
                                        <label class="custom-control-label" for="{{$item}}">{{$item}}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="container text-center p-4">
                <p style="font-family: 'Amatic SC', cursive; font-size: 40px">
                    @lang('labels.chooseTags')
                </p>
            </div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                @foreach($list_tags as $tag)
                                    <div class="custom-control custom-control-inline custom-checkbox mb-2">
                                        <input type="checkbox" class="custom-control-input" name="{{$tag}}" id="{{$tag}}">
                                        <label class="custom-control-label" for="{{$tag}}">{{$tag}}</label>
                                    </div>

                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container pt-4 pb-4">
                <div class="row justify-content-center">
                    <button type="submit" class="btn btn-primary">@lang('labels.searchPlaceholder')</button>
                </div>
            </div>


        </form>
    --}}

    <div class="container">

        <h1 class="h-title text-center my-3">
            @lang('labels.advancedsearch')
        </h1>

        <div class="border border-bottom my-2"></div>

        <form action="{{route('search_advanced')}}" method="post">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="card" >
                        <div class="card-body">
                            <h4 class="card-title">@lang('labels.chooseTags'):</h4>
                            <div class="row pl-3">
                                @foreach($list_tags as $tagnum => $tag)
                                    <div class="col-6 my-1">
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" class="form-check-input" name="tag-{{$tagnum}}" id="tag-{{$tagnum}}">
                                            <label class="form-check-label" for="tag-{{$tagnum}}">{{$tag}}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mt-1 mt-lg-0">
                    <div class="card">
                        <div class="card-body">
                            <h4>@lang('labels.chooseDifficulty'):</h4>
                            <div class="mt-3 d-flex justify-content-center">

                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input" name="easy" id="easy" checked>
                                    <label class="form-check-label" for="easy">@lang('labels.easy')</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input" name="medium" id="medium" checked>
                                    <label class="form-check-label" for="medium">@lang('labels.medium')</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input" name="hard" id="hard" checked>
                                    <label class="form-check-label" for="hard">@lang('labels.hard')</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="my-1"></div>

                    <div class="card" id="filtePerPrepTimeDiv">
                        <div class="card-body">
                            <div class="row flex-nowrap mb-3">
                                <div class="col text-truncate">
                                    <h4 class="text-truncate">@lang('labels.filterPerPrepTime'):</h4>
                                </div>
                                <div class="col-2 d-flex align-items-center justify-content-center">
                                    <label class="switch m-0" >
                                        <input type="checkbox" name="filterPrepTime" id="filterPrepTime" >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col col-form-label" for="minPrepTime" style="color: darkgrey">
                                    @lang('labels.minTime') (@lang('labels.minutes'))
                                </label>
                                <div class="col">
                                    <input type="number" class="form-control" name="minPrepTime" min="0" disabled>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label class="col col-form-label" for="maxPrepTime" style="color: darkgrey">
                                    @lang('labels.maxTime') (@lang('labels.minutes'))
                                </label>
                                <div class="col">
                                    <input type="number" class="form-control" name="maxPrepTime" min="0" disabled>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="my-1"></div>

                    <div class="card" id="filtePerCookTimeDiv">
                        <div class="card-body">
                            <div class="row flex-nowrap mb-3">
                                <div class="col text-truncate">
                                    <h4 class="text-truncate">@lang('labels.filterPerCookTime'):</h4>
                                </div>
                                <div class="col-2 d-flex align-items-center justify-content-center">
                                    <label class="switch m-0">
                                        <input type="checkbox" name="filterCookTime" id="filterCookTime">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col col-form-label" for="minCookTime" style="color: darkgrey">
                                    @lang('labels.minTime') (@lang('labels.minutes'))
                                </label>
                                <div class="col">
                                    <input type="number" class="form-control" name="minCookTime" min="0" disabled>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label class="col col-form-label" for="maxCookTime" style="color: darkgrey">
                                    @lang('labels.maxTime') (@lang('labels.minutes'))
                                </label>
                                <div class="col">
                                    <input type="number" class="form-control" name="maxCookTime" min="0" disabled>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <div class="row justify-content-center my-4">
                <button class="btn btn-outline-primary" style="min-width: 200px">@lang('labels.searchPlaceholder')</button>
            </div>
        </form>
    </div>

    <script>
        function toggleFilterPerPrepTime(enable) {
            $('#filtePerPrepTimeDiv input[type=number]').prop('disabled', !enable);
            // $('#filtePerPrepTimeDiv').css('background', enable ? 'white' : '#eeeeee');
            $('#filtePerPrepTimeDiv label').css('color', enable ? 'black' : 'darkgrey');
        }
        function toggleFilterPerCookTime(enable) {
            $('#filtePerCookTimeDiv input[type=number]').prop('disabled', !enable);
            // $('#filtePerCookTimeDiv').css('background', enable ? 'white' : '#eeeeee');
            $('#filtePerCookTimeDiv label').css('color', enable ? 'black' : 'darkgrey');
        }

        $(document).ready(function () {
            $('#filterPrepTime').click(function () {
                toggleFilterPerPrepTime($('#filterPrepTime').prop('checked'));
            })
            $('#filterCookTime').click(function () {
                toggleFilterPerCookTime($('#filterCookTime').prop('checked'));
            })
        })
    </script>


@endsection
