<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ManageUsersController;
use App\Http\Controllers\FinanceController;
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

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::post('/reset-password', [LoginController::class, 'sendPasswordResetLink']);
Route::post('/reset/password', [LoginController::class, 'callResetPassword']);

Route::middleware('auth:sanctum')->group(function () {
  
    Route::resource('category', CategoryController::class);

    Route::resource('users', ManageUsersController::class);
    Route::post('/profile_upload', [ManageUsersController::class, 'uploadFile']);
    
    Route::get('/user', [ManageUsersController::class, 'getUser']);
    Route::post('/user', [ManageUsersController::class, 'updateUser']);

    

    // Finance Finance Route 
    Route::get('/banks', [FinanceController::class, 'getBanks']);
    Route::post('/add-bank', [FinanceController::class, 'addBank']);
    Route::post('/save-Finance-finance-data', [FinanceController::class, 'saveFinanceData']);
    Route::get('/get-Finance-finance-data/{id}', [FinanceController::class, 'getFinanceData']);
    Route::get('/get-Finance-finance-list', [FinanceController::class, 'getFinanceList']);
    Route::get('/delete-Finance/{id}', [FinanceController::class, 'deleteFinanceData']);
    
    
    
});