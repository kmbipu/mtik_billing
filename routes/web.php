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
Route::match(['get', 'post'], '/login', [App\Http\Controllers\AuthController::class, 'login']);


Route::prefix('admin')->group(function () {

    //Dashboard
    Route::get('/', [App\Http\Controllers\HomeController::class, 'adminHome'])->name('home.view');

    //Roles
    Route::get('/roles', [App\Http\Controllers\Admin\RoleController::class, 'index'])->name('role.view');
    Route::match(['get', 'post'], '/roles/add', [App\Http\Controllers\Admin\RoleController::class, 'add'])->name('role.add');
    Route::match(['get', 'post'], '/roles/edit/{id}', [App\Http\Controllers\Admin\RoleController::class, 'edit'])->name('role.edit');
    Route::post('/roles/delete/{id}', [App\Http\Controllers\Admin\RoleController::class, 'delete'])->name('role.delete');

    //Permissions
    Route::get('/permissions', [App\Http\Controllers\Admin\PermissionController::class, 'index'])->name('permission.view');
    Route::get('/permissions/refresh', [App\Http\Controllers\Admin\PermissionController::class, 'refresh'])->name('permission.refresh');
    Route::post('/permissions/delete-assign', [App\Http\Controllers\Admin\PermissionController::class, 'deleteAssign'])->name('permission.delete_assign');


    //Users
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('role.view');
    Route::match(['get', 'post'], '/users/add', [App\Http\Controllers\Admin\UserController::class, 'add'])->name('role.add');
    Route::match(['get', 'post'], '/users/edit/{id}', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('role.edit');
    Route::post('/users/delete/{id}', [App\Http\Controllers\Admin\UserController::class, 'delete'])->name('role.delete');
    
    //Routers
    Route::get('/routers', [App\Http\Controllers\Admin\RouterController::class, 'index'])->name('role.view');
    Route::match(['get', 'post'], '/routers/add', [App\Http\Controllers\Admin\RouterController::class, 'add'])->name('role.add');
    Route::match(['get', 'post'], '/routers/edit/{id}', [App\Http\Controllers\Admin\RouterController::class, 'edit'])->name('role.edit');
    Route::post('/routers/delete/{id}', [App\Http\Controllers\Admin\RouterController::class, 'delete'])->name('role.delete');
    

});
