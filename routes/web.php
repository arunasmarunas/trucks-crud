<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TruckController;

Route::get('/', function () {
    return view('welcome');
});
Route::resource('trucks', TruckController::class);
Route::get('/add-truck', function () {
    return view('add_truck');
});
Route::get('/update-truck', function () {
    return view('update_truck');
});
