<?php

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
Route::get('/check', function (){
    return response()->json([
        'message'=>'hello world.'
    ]);
});

Route::post('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('register');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', [App\Http\Controllers\AuthController::class, 'user']);
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
});

Route::prefix('companies')->name('companies.')
->controller(App\Http\Controllers\CompanyController::class)->group(function(){
    Route::get('/', 'index')->name('index');
    // Route::get('/create', 'create')->name('create');
    Route::post('/', 'store')->name('store');
    Route::get('/{id}', 'show')->name('show');
    // Route::get('/{id}/edit', 'edit')->name('edit');
    Route::post('/{id}', 'update')->name('update');
    Route::post('/{id}/favorite', 'favorite')->name('favorite');
    Route::post('/{id}/destroy', 'destroy')->name('destroy');
});
