<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\GroomServiceController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;

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
