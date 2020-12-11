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

Route::get('/', 'WelcomeController@welcome')->name('welcome');

Auth::routes();

/** admin */
Route::prefix('/jabss/admin')->group( function() {
    Route::get('/', 'AdminController@index')->name('a_home');
    /** trans */
    Route::get('/trans', 'AdminController@trans')->name('a_trans');
    Route::get('/tran/{id}', 'AdminController@tran')->name('a_tran');
    Route::post('/tran/del/{id}', 'AdminController@deltran')->name('a_deltran');
    /** mpesa */
    Route::get('/mps', 'AdminController@mps')->name('a_mps');
    Route::get('/mp/{id}', 'AdminController@mp')->name('a_mp');
    /** bank */
    Route::get('/bnks', 'AdminController@bnks')->name('a_bnks');
    Route::get('/bnk/{id}', 'AdminController@bnk')->name('a_bnk');
    /** users */
    Route::get('/users', 'AdminController@users')->name('a_users');
    Route::get('/user/{id}', 'AdminController@user')->name('a_user');
    Route::post('/user/del/{id}', 'AdminController@deluser')->name('a_deluser');
    /** admins */
    Route::get('/admins', 'AdminController@admins')->name('a_admins');
    // Route::get('/admin/{id}', 'AdminController@admin')->name('a_admin');
    Route::get('/admin/del/{id}', 'AdminController@deladmin')->name('a_deladmin');
    Route::post('/admin/add', 'AdminController@a_add')->name('a_add');
});
/** courses */
