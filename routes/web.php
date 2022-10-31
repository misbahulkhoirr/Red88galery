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


Auth::routes(['register' => false]);


Route::group(['middleware' => ['auth']], function () {

        Route::get('/', function () {
                return redirect('home');
        });
        Route::get('/home', App\Http\Controllers\HomeController::class);
        Route::get('/change-password', 'App\Http\Controllers\Change_PasswordController@index');
        Route::put('/change-password', 'App\Http\Controllers\Change_PasswordController@update');

        Route::group(['middleware' => ['role:Super Administrator']], function () {
                Route::resource('/location', App\Http\Controllers\LocationController::class);
                Route::resource('/size', App\Http\Controllers\SizeController::class);
                Route::resource('/monthly_cost', App\Http\Controllers\Monthly_costController::class);
                Route::resource('/tank_types', App\Http\Controllers\Tank_typesController::class);
                Route::resource('/fish_type', App\Http\Controllers\Fish_typeController::class);
                Route::resource('users', App\Http\Controllers\UserController::class);
                Route::resource('logs-users', App\Http\Controllers\LogsUserController::class);
        });

        Route::group(['middleware' => ['role:Super Administrator,Administrator']], function () {
                Route::resource('users', App\Http\Controllers\UserController::class);
                Route::resource('/supplier', App\Http\Controllers\SupplierController::class);
                Route::resource('/tank', App\Http\Controllers\TankController::class);
        });

        Route::group(['middleware' => ['role:Super Administrator,Administrator,Keeper']], function () {

                Route::resource('/fish', App\Http\Controllers\FishesController::class);
                Route::get('/fish_histori/create_histori/{id}', 'App\Http\Controllers\FishesController@create_histori');
                Route::post('/fish_histori/tambah_histori/{id}', 'App\Http\Controllers\FishesController@tambah_histori');
                Route::post('/fish/{id}/edit-tank', 'App\Http\Controllers\FishesController@update_tank');
                Route::get('/fish/{id}/edit-tank', 'App\Http\Controllers\FishesController@show_update_tank');
                Route::get('/fish/{id}/sell-fish', 'App\Http\Controllers\FishesController@sell_fish');
                Route::put('/fish/{id}/sell-fish', 'App\Http\Controllers\FishesController@update_sell_fish');
                Route::put('/fish/{id}/edit-tank', 'App\Http\Controllers\FishesController@update_tank');
                Route::get('/get-tank-types/{id}', 'App\Http\Controllers\FishesController@getTypeTanksBylocation');
                Route::get('/get-tanks/{id}', 'App\Http\Controllers\FishesController@getTanksByLocation');
                Route::get('/tank-details-fish/{id}', 'App\Http\Controllers\TankController@tank_details_fish');
        });

        Route::group(['middleware' => ['role:Super Administrator,Administrator,finance']], function () {
                Route::resource('/sales', App\Http\Controllers\SalesController::class);
                Route::get('/sales/{id}/show', 'App\Http\Controllers\SalesController@show');
        });

        Route::resource('/tank', App\Http\Controllers\TankController::class);
});

Route::get('/tank-details/{id}', 'App\Http\Controllers\TankController@tank_details');
