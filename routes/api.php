<?php

use App\Events\TaskCreated;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/projects/{project}', function (Project $project) {
    return $project->tasks()->pluck('body');
});

Route::post('/projects/{project}/tasks', function (Project $project) {
    $task = $project->tasks()->create(request(['body']));

    event(new TaskCreated($task));

    return $task;
});
