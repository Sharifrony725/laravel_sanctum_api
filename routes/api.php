<?php
use App\Http\Controllers\UserController;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function(){
  //return $request->user();
    Route::get('tasks',[TaskController::class ,'index']);
    Route::post('task-store',[TaskController::class ,'store']);
    Route::post('task-update/{Task}',[TaskController::class ,'update']);
    Route::get('task/{id}',[TaskController::class ,'show']);
    Route::delete('task/{id}',[TaskController::class ,'destroy']);
});


Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);
