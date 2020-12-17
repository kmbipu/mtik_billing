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
Route::match(['get', 'post'], '/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout']);


Route::prefix('admin')->middleware(['auth'])->group(function () {

    //Dashboard
    Route::get('/', [App\Http\Controllers\HomeController::class, 'adminHome'])->name('admin.home.view');

    //Roles
    Route::get('/roles', [App\Http\Controllers\Admin\RoleController::class, 'index'])->name('admin.roles.view');
    Route::match(['get', 'post'], '/roles/add', [App\Http\Controllers\Admin\RoleController::class, 'add'])->name('admin.roles.add');
    Route::match(['get', 'post'], '/roles/edit/{id}', [App\Http\Controllers\Admin\RoleController::class, 'edit'])->name('admin.roles.edit');
    Route::post('/roles/delete/{id}', [App\Http\Controllers\Admin\RoleController::class, 'delete'])->name('admin.roles.delete');

    //Permissions
    Route::get('/permissions', [App\Http\Controllers\Admin\PermissionController::class, 'index'])->name('admin.permissions.view');
    Route::get('/permissions/refresh', [App\Http\Controllers\Admin\PermissionController::class, 'refresh'])->name('admin.permissions.refresh');
    Route::post('/permissions/delete-assign', [App\Http\Controllers\Admin\PermissionController::class, 'deleteAssign'])->name('admin.permissions.del_assign');


    //Users
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.view');
    Route::match(['get', 'post'], '/users/add', [App\Http\Controllers\Admin\UserController::class, 'add'])->name('admin.users.add');
    Route::match(['get', 'post'], '/users/edit/{id}', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.users.edit');
    Route::post('/users/delete/{id}', [App\Http\Controllers\Admin\UserController::class, 'delete'])->name('admin.users.delete');
    
    //Routers
    Route::get('/routers', [App\Http\Controllers\Admin\RouterController::class, 'index'])->name('admin.routers.view');
    Route::match(['get', 'post'], '/routers/add', [App\Http\Controllers\Admin\RouterController::class, 'add'])->name('admin.routers.add');
    Route::match(['get', 'post'], '/routers/edit/{id}', [App\Http\Controllers\Admin\RouterController::class, 'edit'])->name('admin.routers.edit');
    Route::post('/routers/delete/{id}', [App\Http\Controllers\Admin\RouterController::class, 'delete'])->name('admin.routers.delete');
    
    //Pools
    Route::get('/pools', [App\Http\Controllers\Admin\PoolController::class, 'index'])->name('admin.pools.view');
    Route::match(['get', 'post'], '/pools/add', [App\Http\Controllers\Admin\PoolController::class, 'add'])->name('admin.pools.add');
    Route::match(['get', 'post'], '/pools/edit/{id}', [App\Http\Controllers\Admin\PoolController::class, 'edit'])->name('admin.pools.edit');
    Route::post('/pools/delete/{id}', [App\Http\Controllers\Admin\PoolController::class, 'delete'])->name('admin.pools.delete');
    Route::get('/pools/get-by-router/{id}', [App\Http\Controllers\Admin\PoolController::class, 'getByRouter'])->name('admin.pools.get');
    
    
    //Bandwidths
    Route::get('/bandwidths', [App\Http\Controllers\Admin\BandwidthController::class, 'index'])->name('admin.bandwidths.view');
    Route::match(['get', 'post'], '/bandwidths/add', [App\Http\Controllers\Admin\BandwidthController::class, 'add'])->name('admin.bandwidths.add');
    Route::match(['get', 'post'], '/bandwidths/edit/{id}', [App\Http\Controllers\Admin\BandwidthController::class, 'edit'])->name('admin.bandwidths.edit');
    Route::post('/bandwidths/delete/{id}', [App\Http\Controllers\Admin\BandwidthController::class, 'delete'])->name('admin.bandwidths.delete');
    
    //Plans
    Route::get('/plans', [App\Http\Controllers\Admin\PlanController::class, 'index'])->name('admin.plans.view');
    Route::match(['get', 'post'], '/plans/add', [App\Http\Controllers\Admin\PlanController::class, 'add'])->name('admin.plans.add');
    Route::match(['get', 'post'], '/plans/edit/{id}', [App\Http\Controllers\Admin\PlanController::class, 'edit'])->name('admin.plans.edit');
    Route::post('/plans/delete/{id}', [App\Http\Controllers\Admin\PlanController::class, 'delete'])->name('admin.plans.delete');
    Route::get('/plans/get-by-router/{id}', [App\Http\Controllers\Admin\PlanController::class, 'getByRouter'])->name('admin.plans.get');
    
    
    //Prepaids
    Route::get('/prepaids/', [App\Http\Controllers\Admin\PrepaidController::class, 'index'])->name('admin.prepaids.view');
    Route::match(['get', 'post'], '/prepaids/edit/{id}', [App\Http\Controllers\Admin\PrepaidController::class, 'edit'])->name('admin.prepaids.edit');
    Route::match(['get', 'post'], '/prepaids/recharge', [App\Http\Controllers\Admin\PrepaidController::class, 'recharge'])->name('admin.prepaids.recharge');
    Route::match(['get', 'post'], '/prepaids/renew/{id}', [App\Http\Controllers\Admin\PrepaidController::class, 'renew'])->name('admin.prepaids.renew');
    Route::post('/prepaids/delete/{id}', [App\Http\Controllers\Admin\PrepaidController::class, 'delete'])->name('admin.prepaids.delete');
    
    //Transactions
    Route::get('/transactions/', [App\Http\Controllers\Admin\TransactionController::class, 'index'])->name('admin.transactions.view');
    Route::match(['get', 'post'], '/transactions/edit/{id}', [App\Http\Controllers\Admin\TransactionController::class, 'edit'])->name('admin.transactions.edit');
    Route::post('/transactions/delete/{id}', [App\Http\Controllers\Admin\TransactionController::class, 'delete'])->name('admin.transactions.delete');
    

});
