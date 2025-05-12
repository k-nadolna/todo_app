<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;

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

Route::controller(UserController::class)->group(function(){
  Route::get('/', 'showDashboard')->name('dashboard');    
  Route::post('/register', 'register')->name('register'); 
  Route::post('/login', 'login')->name('login');
  Route::post('/logout', 'logout')->name('logout');
});



Route::prefix('tasks')->name('tasks.')->controller(TaskController::class)->group(function (){
  Route::post('/store', 'store')->name('store');
  Route::get('/{task}/edit', 'edit')->name('edit');
  Route::put('/{task}', 'update')->name('update');
  Route::delete('/{task}', 'destroy')->name('destroy');
  Route::put('/{task}/complete', 'complete')->name('complete');
  Route::delete('/completed/destroy', 'destroyCompleted')->name('completed.destroy');
});

