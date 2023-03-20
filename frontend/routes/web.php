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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/home', function () {
    return view('layouts.base');
});

// Dashboard links
Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/user-list', function () {
    return view('tables.user');
});
Route::get('/customer-list', function () {
    return view('tables.customer');
});
Route::get('/employee-list', function () {
    return view('tables.employee');
});

Route::get('/pet-list', function () {
    return view('tables.pet');
});

Route::get('/service-list', function () {
    return view('tables.service');
});


Route::view('/login', 'auth.login');