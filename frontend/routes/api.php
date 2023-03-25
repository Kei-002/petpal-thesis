<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\GroomServiceController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



// Authentication routes // Public Routes
// Route::post('/login', [AuthController::class, 'login']);
// Route::post('/register', [AuthController::class, 'register']);

// // Protected Routes

//     // Route::resource('user', UserController::class);
// Route::post('/logout', [AuthController::class, 'logout']);


Route::group(['middleware' => ['check_role:employee,admin']], function () {
    Route::resource('user', UserController::class);
    Route::post('/user-update/{user}', [UserController::class, 'updateUser']);
    Route::resource('customer', CustomerController::class);
    Route::post('/customer-update/{customer}', [CustomerController::class, 'updateCustomer']);
    Route::resource('employee', EmployeeController::class);
    Route::post('/employee-update/{employee}', [EmployeeController::class, 'updateEmployee']);
    Route::resource('pet', PetController::class);
    Route::post('/pet-update/{pet}', [PetController::class, 'updatePet']);
    Route::resource('service', GroomServiceController::class);
    Route::post('/service-update/{service}', [GroomServiceController::class, 'updateService']);
    Route::resource('product', ProductController::class);
    Route::post('/product-update/{product}', [ProductController::class, 'updateProduct']);
});

Route::resource('category', CategoryController::class);
Route::get('/get-all-products', [OrderController::class, 'getProductPageDetails']);