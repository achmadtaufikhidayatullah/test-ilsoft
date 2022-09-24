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
    return redirect()->route('user.index');
});
Route::prefix('admin')->middleware('auth')->group(function(){
   
   // USER
   Route::resource('user', App\Http\Controllers\UserController::class);
   Route::resource('product', App\Http\Controllers\ProductController::class);

   // SWAP
   Route::get('/swap', [App\Http\Controllers\LogicTestController::class, 'indexSwap'])->name('swap.index');
   Route::post('/swap', [App\Http\Controllers\LogicTestController::class, 'resultSwap'])->name('swap.post');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/regist', function () {
    return view('auth.register-lte');
})->name('regist');
Route::post('/regist', [App\Http\Controllers\UserController::class, 'regist'])->name('regist.post');