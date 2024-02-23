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
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// 認証関連ルーティング
Route::post('/register', 'App\Http\Controllers\AuthController@register');
Route::post('/login', 'App\Http\Controllers\AuthController@login');

// Route::resource('contacts', ContactFormController::class);
// 分解するとこう
Route::prefix('companies')->name('companies.')
->controller(App\Http\Controllers\CompanyController::class)->group(function(){
    Route::get('/', 'index')->name('index');
    // Route::get('/create', 'create')->name('create');
    Route::post('/', 'store')->name('store');
    Route::get('/{id}', 'show')->name('show');
    // Route::get('/{id}/edit', 'edit')->name('edit');
    Route::post('/{id}', 'update')->name('update');
    Route::post('/{id}/destroy', 'destroy')->name('destroy');
});

Route::prefix('/')->group(function () {
    
    Route::get('/', function (){
        return response()->json([
            'message'=>'hello world.'
        ]);
    });

    Route::get('/laravel', function () {
        return view('welcome');
    });
});