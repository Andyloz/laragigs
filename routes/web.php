<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
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

// Listings views

Route::get('/', [ListingController::class, 'index']);

Route::get('/listings/create', [ListingController::class, 'create'])
    ->middleware('auth');

Route::get('/listings/manage', [ListingController::class, 'manage'])
    ->middleware('auth');

Route::get('/listings/{listing}', [ListingController::class, 'show'])
    ->where('id', '\d+');

Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])
    ->middleware('auth');

// Listings api

Route::post('/listings', [ListingController::class, 'store'])
    ->middleware('auth');

Route::put('/listings/{listing}', [ListingController::class, 'update'])
    ->middleware('auth');

Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])
    ->middleware('auth');


// Authentication views

Route::get('/register', [UserController::class, 'create'])
    ->middleware('guest');

Route::get('/login', [UserController::class, 'login'])
    ->middleware('guest')
    ->name('login');

// Authentication api

Route::post('/users', [UserController::class, 'store']);

Route::post('/logout', [UserController::class, 'logout'])
    ->middleware('auth');

Route::post('/authenticate', [UserController::class, 'authenticate']);
