<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConsultationController;
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

// Private routes for employee and admin
// Route::group(['middleware' => ['check_role:employee']], function () {
//     Route::resource('user', UserController::class)->except('delete');
//     Route::post('/user-update/{user}', [UserController::class, 'updateUser']);
//     Route::resource('customer', CustomerController::class)->except('delete');
//     Route::post('/customer-update/{customer}', [CustomerController::class, 'updateCustomer']);
//     Route::resource('employee', EmployeeController::class)->except('delete');
//     Route::post('/employee-update/{employee}', [EmployeeController::class, 'updateEmployee']);
//     Route::resource('pet', PetController::class)->except('delete');
//     Route::post('/pet-update/{pet}', [PetController::class, 'updatePet']);
//     Route::resource('service', GroomServiceController::class)->except('delete');
//     Route::post('/service-update/{service}', [GroomServiceController::class, 'updateService']);
//     Route::resource('product', ProductController::class)->except('delete');
//     Route::post('/product-update/{product}', [ProductController::class, 'updateProduct']);
// });

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

Route::get('/all-orders', [OrderController::class, 'getAllOrders']);
Route::get('/all-transactions', [OrderController::class, 'getAllTransactions']);
Route::post('/update-order-status/{order}', [OrderController::class, 'updateOrderStatus']);
Route::post('/update-transaction-status/{transaction}', [OrderController::class, 'updateTransactionStatus']);
// Public Routes
Route::resource('category', CategoryController::class);
Route::get('/get-all-products', [OrderController::class, 'getAllProducts']);
Route::get('/get-all-services', [OrderController::class, 'getAllServices']);
Route::get('/get-all-services', [OrderController::class, 'getAllServices']);
Route::get('/get-product/{product}', [OrderController::class, 'getProductDetails']);
Route::get('/receipt-info/{order}', [OrderController::class, 'getReceipt']);

// Routes for customers only
Route::group(['middleware' => ['check_role:customer']], function () {
    Route::post('/checkout', [OrderController::class, 'checkout']);
    Route::get('/get-owned-pets', [OrderController::class, 'getOwnedPets']);
    Route::resource('consultation', ConsultationController::class);
    Route::post('/owner-add-pet', [PetController::class, 'customerAddPet']);
    Route::get('/owner-edit-pet/{pet}', [PetController::class, 'customerEditPet']);
    Route::post('/owner-update-pet/{pet}', [PetController::class, 'customerUpdatePet']);
    Route::delete('/owner-delete-pet/{pet}', [PetController::class, 'customerDeletePet']);
});
