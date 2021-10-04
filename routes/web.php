<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/
 
Route::get('/', function () {
    return view('app');
})->where('any', '.*');

Route::get('/dashboard', function () {
    return view('dashboard');
})->where('any', '.*');