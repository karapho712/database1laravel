<?php

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
Route::permanentRedirect('/', '/admin')
    ->middleware(['auth','admin']);

Route::prefix('admin')
    ->namespace('Admin')
    ->middleware(['auth','admin'])
    ->group(function() {
        Route::get('/', 'DashboardController@index')
            ->name('dashboard');

            Route::resource('database', 'DatabasesController' )
            ->middleware(['auth','admin']);

            Route::get('database/destroy/{id}','DatabasesController@destroy')
            ->middleware(['auth','admin']);

            Route::post('database/update','DatabasesController@update')
            ->name('database.update')
            ->middleware(['auth','admin']);

            Route::resource('periode', 'PeriodeController' )
            ->middleware(['auth','admin']);

            Route::post('periode/update','PeriodeController@update')
            ->name('periode.update')
            ->middleware(['auth','admin']);

            Route::get('periode/destroy/{id}','PeriodeController@destroy')
            ->middleware(['auth','admin']);

        // Route::get('database', 'DatabasesController@index')
        //     ->name('database');

//              
    });
Auth::routes();

// Route::get('/', 'DashboardController@index')->name('dashboard');

// Route::get('/', function () {
//     return view('dashboard');
// });
