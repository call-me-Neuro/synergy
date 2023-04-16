<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MySiteController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LogisterController;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\App;

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
    return redirect()->route('home');
});

Route::middleware(['set_locale'])->group(function () {
    Route::get('/home', 'App\Http\Controllers\MySiteController@home')->name('home');
    Route::get('/sign_up', 'App\Http\Controllers\RegisterController@index')->name('registration');
    Route::post('/register', 'App\Http\Controllers\RegisterController@register');
    Route::get('/sign_in', 'App\Http\Controllers\LogisterController@index')->name('login');
    Route::post('/logister', 'App\Http\Controllers\LogisterController@login');
    Route::get('/logout', 'App\Http\Controllers\LogisterController@logout');
    Route::get('/setlocale/{locale}', 'App\Http\Controllers\MySiteController@set_locale')->name('setlocale');

    Route::middleware(['is_admin'])->group(function () {
        Route::get('/admin', 'App\Http\Controllers\AdminController@index');
        Route::get('/admin/q/{id}', 'App\Http\Controllers\AdminController@get_qs');
        Route::get('/admin/edit/{id}', 'App\Http\Controllers\AdminController@edit_page');
        Route::post('/admin/edit/{id}/post', 'App\Http\Controllers\AdminController@edit_page_post');
        Route::get('/admin/create', 'App\Http\Controllers\AdminController@create_get');
        Route::post('/admin/create/create', 'App\Http\Controllers\AdminController@create_post');
        Route::get('/admin/delete/{id}', 'App\Http\Controllers\AdminController@delete_questionnaire');
    });
    
    Route::middleware(['auth'])->group(function () {
        Route::get('/profile', 'App\Http\Controllers\ProfileController@profile')->name('profile');
        Route::get('/profile/edit', 'App\Http\Controllers\ProfileController@profile_edit');
        Route::post('/profile/edit/edit', 'App\Http\Controllers\ProfileController@profile_edit_edit');
        Route::get('/profile/get/{id}', 'App\Http\Controllers\ProfileController@get');
        Route::post('/profile/get/post', 'App\Http\Controllers\ProfileController@get_post');

        Route::get('/change/m/', 'App\Http\Controllers\MySiteController@change_email_page')->name('confirm.m');
        Route::post('/change/m/create', 'App\Http\Controllers\MySiteController@change_email_create');
        Route::get('/confirm/m/{id}', 'App\Http\Controllers\MySiteController@confirm_email');
        Route::get('/change/p/', 'App\Http\Controllers\MySiteController@change_password_page')->name('confirm.p');
        Route::post('/change/p/create', 'App\Http\Controllers\MySiteController@change_password_create');
        Route::get('/confirm/p/{id}', 'App\Http\Controllers\MySiteController@confirm_password');
    });
});
