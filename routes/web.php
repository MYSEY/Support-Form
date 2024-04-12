<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admins\UserController;
use App\Http\Controllers\Admins\BranchController;
use App\Http\Controllers\Admins\TicketController;
use App\Http\Controllers\Admins\PriorityController;
use App\Http\Controllers\Admins\StatusesController;
use App\Http\Controllers\Admins\DashboardController;
use App\Http\Controllers\Admins\IssueTypeController;
use App\Http\Controllers\Admins\DepartmentController;

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
Route::get('/', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'login']);
// Route::get('/', function () {
//     // return view('layouts.admin');
//     return view('welcome');
// });

Auth::routes();
Route::group(['middleware'=>['auth:sanctum'], 'prefix'=>'admin'],function(){
    Route::get('/dashboad', [DashboardController::class, 'index']);

    // users 
    Route::get('/user', [UserController::class, 'index']);
    Route::post('/user/show', [UserController::class, 'show']);
    Route::post('/user/create', [UserController::class, 'store']);
    Route::post('/user/delete', [UserController::class, 'destroy']);

    // Ticket  
    Route::get('/ticket', [TicketController::class, 'index']);

    // Statuses
    Route::get('/statuses', [StatusesController::class, 'index']);
    Route::post('/statuses/store', [StatusesController::class,'store']);
    Route::post('/statuses/update', [StatusesController::class,'update']);
    Route::post('/statuses/delete', [StatusesController::class,'destroy']);

    // Department
    Route::get('/department', [DepartmentController::class, 'index']);
    Route::post('/department/store', [DepartmentController::class,'store']);
    Route::post('/department/update', [DepartmentController::class,'update']);
    Route::post('/department/delete', [DepartmentController::class,'destroy']);

    // Branch
    Route::get('/branch', [BranchController::class, 'index']);
    Route::post('/branch/store', [BranchController::class,'store']);
    Route::get('/branch/edit', [BranchController::class,'edit']);
    Route::post('/branch/update', [BranchController::class,'update']);
    Route::post('/branch/delete', [BranchController::class,'destroy']);

    Route::resource('priority', PriorityController::class);
    Route::resource('issue-type', IssueTypeController::class);
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
