<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API;

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
    Route::resource('user',API\UserController::class);
    Route::resource('project',API\ProjectController::class);
    Route::resource('task',API\TaskController::class);
    Route::resource('projects_shared',API\SharedController::class);
    Route::resource('tasks_shared',API\SharedTaskController::class);
});
