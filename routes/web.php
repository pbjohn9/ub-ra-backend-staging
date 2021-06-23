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

use App\Http\Controllers\UsersController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();


Route::group(['middleware'=>['auth']],function(){

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/profile',[HomeController::class,'viewProfile'])->name('profile');
    Route::patch('/profile',[HomeController::class,'updateProfile'])->name('profile.update');

    Route::resource('users',UsersController::class);
    Route::resource('permissions',PermissionsController::class);
    Route::resource('roles',RolesController::class);

});
