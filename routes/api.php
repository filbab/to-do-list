<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:sanctum')->group(function () {
});
// List tasks
Route::get('tasks', [TaskController::class, 'index'])->name('tasks.index');

// Create task (with status and users)
Route::post('tasks', [TaskController::class, 'store'])->name('tasks.store');

// Update task (with status and users)
Route::put('tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');

// Delete task
Route::delete('tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');