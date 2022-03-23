<?php

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

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Rutas de autenticaciíon con azure
Route::get('azure/logout',App\Http\Controllers\LogoutController::class)->name('azure.logout');
Route::get('callback',[App\Http\Controllers\SocialiteController::class,'callback'])->name('callback');
Route::get('redirect', App\Http\Controllers\RedirectController::class)->name('redirect');

// Rutas del Panel Administrativo General
Route::resource('credentials', App\Http\Controllers\CredentialController::class);
Route::resource('settings', App\Http\Controllers\SettingController::class);