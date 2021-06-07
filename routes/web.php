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

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\ProjectController::class, 'index'])->name('project.index');


Route::get('/password/change', function () {
    return view('auth.passwords.change');
});



Route::get('getProgressDashboard',[App\Http\Controllers\ProjectController::class, 'getData'])->name('project.detail2');


Route::get('project',[App\Http\Controllers\ProjectController::class, 'index'])->name('project.index');
Route::get('project/{id}',[App\Http\Controllers\ProjectController::class, 'show'])->name('project.show');
Route::get('project/{id}/edit',[App\Http\Controllers\ProjectController::class, 'edit'])->name('project.edit');
Route::post('project',[App\Http\Controllers\ProjectController::class, 'store'])->name('project.store');
Route::put('project/{id}',[App\Http\Controllers\ProjectController::class, 'update'])->name('project.update');
Route::delete('project/{id}',[App\Http\Controllers\ProjectController::class, 'destroy'])->name('project.destroy');

Route::get('getProgressProject',[App\Http\Controllers\TaskController::class, 'getDataByProject'])->name('project.curva');

Route::post('task',[App\Http\Controllers\TaskController::class, 'store'])->name('task.store');
Route::put('task/{id}',[App\Http\Controllers\TaskController::class, 'update'])->name('task.update');
Route::get('task/{id}/edit',[App\Http\Controllers\TaskController::class, 'edit'])->name('task.edit');
Route::delete('task/{id}',[App\Http\Controllers\TaskController::class, 'destroy'])->name('task.destroy');

Route::get('subtask',[App\Http\Controllers\SubtaskController::class, 'create'])->name('subtask.create');
Route::post('subtask',[App\Http\Controllers\SubtaskController::class, 'store'])->name('subtask.store');
Route::delete('subtask/{id}',[App\Http\Controllers\SubtaskController::class, 'destroy'])->name('subtask.destroy');
Route::get('subtask/{id}/edit',[App\Http\Controllers\SubtaskController::class, 'edit'])->name('subtask.edit');
Route::put('subtask/{id}',[App\Http\Controllers\SubtaskController::class, 'update'])->name('subtask.update');

Route::get('attendance',[App\Http\Controllers\AttendanceController::class, 'index'])->name('attendance.index');

Route::post('changePassword',[App\Http\Controllers\AuthController::class, 'changePassword']);
