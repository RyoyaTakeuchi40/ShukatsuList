<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('api')->group(function () {
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('/user', [App\Http\Controllers\AuthController::class, 'user']);

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
    });
});
