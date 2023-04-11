<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
    return view('welcome');
});


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);


// Dashboard links

Route::group(['middleware' => ['check_role_web:employee,admin']], function () {
    Route::get('/dashboard', function () {
        return view('tables.main_dashboard');
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
    Route::view('/product-list', 'tables.product');
    Route::view('/order-list', 'tables.order');
    Route::view('/transaction-list', 'tables.transaction');
});

// Route::view('/401', 'errors.401');
// Route::view('/503', 'errors.503');

Route::view('/product', 'items.product');
Route::view('/products', 'items.products');
Route::view('/services', 'items.services');
Route::view('/consultation', 'items.consultation');
Route::view('/login', 'auth.login');

Route::view('/cart', 'items.cart');
Route::view('/profile', 'auth.profile');
Route::view('/receipt', 'items.receipt', ["order_id", "transaction_id"]);
