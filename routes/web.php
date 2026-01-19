<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', fn () => redirect('admin'))->name('dashboard');


    // i will be using this so that i can seperate the admin panel and it having full filament suport no issues
    // and i can use web as a route for the cashier side for livewire blade
    //probable will create a role check but that sould be easy because i can make it the be the same as prev system
    //also i only really have 2 role admin and cashier adn manager but that came later
    
});
