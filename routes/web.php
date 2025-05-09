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

Route::get('/', function () {
    $tasks = [];
    if(auth()->check()){
        $tasks =  auth()->user()->usersCoolTasks()->latest()->get();
    }
       
        return view('home', ['tasks'=> $tasks]);

   
   
});

Route::post('/register', [UserController::class, 'register']); 
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);

Route::post('/add-task', [TaskController::class, 'addTask']);
Route::get('/edit-task/{task}', [TaskController::class, 'showEditScreen']);
Route::put('/edit-task/{task}', [TaskController::class, 'actuallyUpdatePost']);
Route::post('/cancel', [TaskController::class, 'cancel']);
Route::delete('/delete-task/{task}', [TaskController::class, 'delete']);
Route::put('/task-completed/{task}', [TaskController::class, 'taskCompleted']);
Route::delete('/remove-completed', [TaskController::class, 'removeCompleted']);

