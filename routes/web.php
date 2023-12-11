<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\Backend\DataController;
use App\Http\Controllers\Backend\CentrePointController;
use App\Http\Controllers\Backend\SpotController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('spot', [SpotController::class, 'index'])->middleware(['auth', 'verified'])->name('home');

Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::resource('spot', SpotController::class);
});

Route::middleware(['auth', 'verified', 'user'])->group(function () {
    Route::resource('spot', SpotController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// route datatables
Route::get('/centre-point/data', [DataController::class, 'centrepoint'])->name('centre-point-data');
Route::get('/spot/data', [DataController::class, 'spot'])->name('spot-data');

Route::resource('spot', SpotController::class);
require __DIR__.'/auth.php';