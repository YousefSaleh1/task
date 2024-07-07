<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Api\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');

//////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// Student Request //////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////

Route::get('students', [StudentController::class, 'index']);

Route::get('student/{student}', [StudentController::class, 'show']);
Route::middleware(['auth:api'])->group(function () {
    Route::post('student-create', [StudentController::class, 'store']);
});

//////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////// End Student Request ///////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
