<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Affiliate\StatisticsController;
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
    return view('welcome');
});

Route::get('/statistics', [StatisticsController::class, 'index'])->middleware('statistical-cache-control-header')->name('statistics');
Route::get('/statistics/{user}/graphical', [StatisticsController::class, 'graphical'])->middleware('statistical-cache-control-header')->name('statistics.graphical');
Route::get('/statistics/{user}/tabular', [StatisticsController::class, 'tabular'])->middleware('statistical-cache-control-header')->name('statistics.tabular');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
