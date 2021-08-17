<?php

use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/get',[MovieController::class,'get_N'])->name('get_n');
Route::post('/delete/post',[MovieController::class,'delete_post']);
Route::get('/delete',[MovieController::class,'delete']);
Route::get('/watched',[MovieController::class,'watched']);
Route::get('/recommend',[MovieController::class,'recommend']);
Route::get('/modify',[MovieController::class,'modify']);
Route::post('/modify/post',[MovieController::class,'modify_post']);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
