<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ImageController;
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

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Auth::routes();




Route::post('/home/storeorder', 
	[App\Http\Controllers\HomeController::class, 'storeorder'])->name('home.storeorder');


Route::post('/home/confirmorder', 
	[App\Http\Controllers\HomeController::class, 'confirmorder'])->name('home.confirmorder');

Route::get('/home/cart', 
	[App\Http\Controllers\HomeController::class, 'cart'])->name('home.cart');

Route::resource('/home', 'App\Http\Controllers\HomeController');

Route::get('/', function () {
    return redirect()->route('home.index');
});



//----

Route::get('/nomenclatures/set_main_image/', 
	[App\Http\Controllers\NomenclaturesController::class, 'set_main_image']);

Route::get('/nomenclatures/delete_image/', 
	[App\Http\Controllers\NomenclaturesController::class, 'delete_image']);

Route::resource('nomenclatures', 'App\Http\Controllers\NomenclaturesController');

//----


Route::resource('images', 'App\Http\Controllers\ImageController');