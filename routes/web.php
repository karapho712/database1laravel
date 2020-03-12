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

            Route::resource('database', 'DatabasesController');

            Route::get('database/destroy/{id}','DatabasesController@destroy');

            Route::post('database/update','DatabasesController@update')
            ->name('database.update');

            Route::resource('periode', 'PeriodeController');

            Route::post('periode/update','PeriodeController@update')
            ->name('periode.update');

            Route::get('periode/destroy/{id}','PeriodeController@destroy');

            Route::get('export', 'DatabasesController@databasesExport')
            ->name('database.export');

            Route::post('import', 'DatabasesController@databasesImport')
            ->name('database.import');

            Route::get('cetakpdf', 'DatabasesController@cetak_pdf')
            ->name('cetakpdf');

        // Route::get('database', 'DatabasesController@index')
        //     ->name('database');

//              
    });
Auth::routes();

// Route::get('/', 'DashboardController@index')->name('dashboard');

// Route::get('/', function () {
//     return view('dashboard');
// });
