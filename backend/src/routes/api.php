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

Route::middleware(['middleware' => 'api'])->group(function () {
    # 投稿作成
    Route::post('/posts/create', 'PostController@create');
    # 投稿一覧表示
    Route::get('/posts', 'PostController@index');
    # 投稿表示
    Route::get('/posts/{id}', 'PostController@show');
    # 投稿編集
    Route::patch('/posts/update/{id}' , 'PostController@update');
    # 投稿削除
    Route::delete('/posts/{id}', 'PostController@delete');
    
    Route::get('selection', [App\Http\Controllers\Api\List\ListController::class, 'index']);
    Route::get('selection/{apply_id}', [App\Http\Controllers\Api\List\ListController::class, 'show']);
    Route::post('selection/{apply_id}', [App\Http\Controllers\Api\List\ListController::class, 'update']);
});
