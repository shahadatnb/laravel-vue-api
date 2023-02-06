<?php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectsContoller;
use App\Http\Controllers\Api\TasksController;
use App\Http\Controllers\Api\FilesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::post('/authenticate', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/logout', function (Request $request) {
    $user = $request->user();
    $user->tokens()->delete();
    Auth::guard('web')->logout();
    return ['status'=>'ok'];

});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('projects', ProjectsContoller::class);
    Route::apiResource('tasks', TasksController::class)->except(['index', 'show']);
    Route::post('upload', [FilesController::class, 'store']);
});