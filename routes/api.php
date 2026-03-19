<?php

use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return Ingredient::all();
});//->middleware('auth:sanctum') you need this remove for this to work

//problem:
    // -i cant use post man on api to check json request

//why not:
//ok it does not work if thier is an auth:sanctum, if remove it will work

//this works in postman now

