<?php

use Illuminate\Support\Facades\Route;

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
    return view('task_list');
});

//Route::post('/task/create', [\App\Http\Controllers\TaskController::class, 'create']);
Route::get('/task/', [\App\Http\Controllers\TaskController::class, 'findAll']);
Route::get('/task/remove/{id}', [\App\Http\Controllers\TaskController::class, 'remove']);
Route::post('/task/save/', [\App\Http\Controllers\TaskController::class, 'save']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
