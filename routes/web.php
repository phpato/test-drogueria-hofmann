<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/get_list_clients', [App\Http\Controllers\HomeController::class, 'getListClient']);
Route::get('/get_code_users', [App\Http\Controllers\HomeController::class, 'getCodeUsers']);

Route::post('/send_data', [App\Http\Controllers\HomeController::class, 'sendData']);

