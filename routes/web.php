<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TruckController;

Route::get('/', function () {
    return view('welcome');
});
// Route to display list of trucks blade
Route::resource('/trucks', TruckController::class);
// Custom route for displaying the "Add New Truck" form
Route::get('add-truck', [TruckController::class, 'create'])->name('trucks.create');
// Route  to display update truck blade
Route::get('/update-truck', function () {
    return view('update-truck');
});
// Route to insert/post a new subunit record
Route::post('/trucks/{truck}/edit', [TruckController::class, 'update'])->name('subunits.store');