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
if (env('APP_ENV') === 'production') {
    URL::forceScheme('https');
}


Route::get('/', [App\Http\Controllers\PageController::class, 'home']);
Route::match(['get', 'post'], '/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::match(['get', 'post'], '/change-password', [App\Http\Controllers\AuthController::class, 'changePassword'])->name('change-password');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout']);


Route::get('/cron', [App\Http\Controllers\CronController::class, 'execute']);

Route::middleware(['auth','role'])->group(function () {
    
    Route::prefix('admin')->group(function () {
        
        //Dashboard
        Route::get('/', [App\Http\Controllers\PageController::class, 'adminHome'])->name('admin.home');
        
        //Roles
        Route::get('/roles', [App\Http\Controllers\Admin\RoleController::class, 'list'])->name('admin.roles.list');
        Route::match(['get', 'post'], '/roles/add', [App\Http\Controllers\Admin\RoleController::class, 'add'])->name('admin.roles.add');
        Route::match(['get', 'post'], '/roles/edit/{id}', [App\Http\Controllers\Admin\RoleController::class, 'edit'])->name('admin.roles.edit');
        Route::post('/roles/delete/{id}', [App\Http\Controllers\Admin\RoleController::class, 'delete'])->name('admin.roles.delete');
        
        //Permissions
        Route::get('/permissions', [App\Http\Controllers\Admin\PermissionController::class, 'list'])->name('admin.permissions.list');
        Route::get('/permissions/refresh', [App\Http\Controllers\Admin\PermissionController::class, 'refresh'])->name('admin.permissions.refresh');
        Route::post('/permissions/delete-assign', [App\Http\Controllers\Admin\PermissionController::class, 'deleteAssign'])->name('admin.permissions.del_assign');
        
        
        //Users
        Route::get('/users/customers', [App\Http\Controllers\Admin\UserController::class, 'customerList'])->name('admin.users.customers.list');
        Route::get('/users/resellers', [App\Http\Controllers\Admin\UserController::class, 'resellerList'])->name('admin.users.resellers.list');
        
        Route::match(['get', 'post'], '/users/customers/add', [App\Http\Controllers\Admin\UserController::class, 'addCustomer'])->name('admin.users.customer.add');
        Route::match(['get', 'post'], '/users/resellers/add', [App\Http\Controllers\Admin\UserController::class, 'addReseller'])->name('admin.users.reseller.add');
        Route::match(['get', 'post'], '/users/edit/{id}', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.users.edit');
        Route::post('/users/delete/{id}', [App\Http\Controllers\Admin\UserController::class, 'delete'])->name('admin.users.delete');
        
        //Routers
        Route::get('/routers', [App\Http\Controllers\Admin\RouterController::class, 'list'])->name('admin.routers.list');
        Route::match(['get', 'post'], '/routers/add', [App\Http\Controllers\Admin\RouterController::class, 'add'])->name('admin.routers.add');
        Route::match(['get', 'post'], '/routers/edit/{id}', [App\Http\Controllers\Admin\RouterController::class, 'edit'])->name('admin.routers.edit');
        Route::post('/routers/delete/{id}', [App\Http\Controllers\Admin\RouterController::class, 'delete'])->name('admin.routers.delete');
        
        //Pools
        Route::get('/pools', [App\Http\Controllers\Admin\PoolController::class, 'list'])->name('admin.pools.list');
        Route::match(['get', 'post'], '/pools/add', [App\Http\Controllers\Admin\PoolController::class, 'add'])->name('admin.pools.add');
        Route::match(['get', 'post'], '/pools/edit/{id}', [App\Http\Controllers\Admin\PoolController::class, 'edit'])->name('admin.pools.edit');
        Route::post('/pools/delete/{id}', [App\Http\Controllers\Admin\PoolController::class, 'delete'])->name('admin.pools.delete');
        Route::get('/pools/get-by-router/{id}', [App\Http\Controllers\Admin\PoolController::class, 'getByRouter'])->name('admin.pools.get');
        
        
        //Bandwidths
        Route::get('/bandwidths', [App\Http\Controllers\Admin\BandwidthController::class, 'list'])->name('admin.bandwidths.list');
        Route::match(['get', 'post'], '/bandwidths/add', [App\Http\Controllers\Admin\BandwidthController::class, 'add'])->name('admin.bandwidths.add');
        Route::match(['get', 'post'], '/bandwidths/edit/{id}', [App\Http\Controllers\Admin\BandwidthController::class, 'edit'])->name('admin.bandwidths.edit');
        Route::post('/bandwidths/delete/{id}', [App\Http\Controllers\Admin\BandwidthController::class, 'delete'])->name('admin.bandwidths.delete');
        
        //Plans
        Route::get('/plans', [App\Http\Controllers\Admin\PlanController::class, 'list'])->name('admin.plans.list');
        Route::match(['get', 'post'], '/plans/add', [App\Http\Controllers\Admin\PlanController::class, 'add'])->name('admin.plans.add');
        Route::match(['get', 'post'], '/plans/edit/{id}', [App\Http\Controllers\Admin\PlanController::class, 'edit'])->name('admin.plans.edit');
        Route::post('/plans/delete/{id}', [App\Http\Controllers\Admin\PlanController::class, 'delete'])->name('admin.plans.delete');
        Route::get('/plans/get-by-router/{id}', [App\Http\Controllers\Admin\PlanController::class, 'getByRouter'])->name('admin.plans.get');
        
        
        //Prepaids
        Route::get('/prepaids/', [App\Http\Controllers\Admin\PrepaidController::class, 'list'])->name('admin.prepaids.list');
        Route::match(['get', 'post'], '/prepaids/edit/{id}', [App\Http\Controllers\Admin\PrepaidController::class, 'edit'])->name('admin.prepaids.edit');
        Route::match(['get', 'post'], '/prepaids/recharge', [App\Http\Controllers\Admin\PrepaidController::class, 'recharge'])->name('admin.prepaids.recharge');
        Route::match(['get', 'post'], '/prepaids/renew/{id}', [App\Http\Controllers\Admin\PrepaidController::class, 'renew'])->name('admin.prepaids.renew');
        Route::post('/prepaids/delete/{id}', [App\Http\Controllers\Admin\PrepaidController::class, 'delete'])->name('admin.prepaids.delete');
        
        //Transactions
        Route::get('/transactions/recharges', [App\Http\Controllers\Admin\TransactionController::class, 'rechargeList'])->name('admin.transactions.recharges.list');
        Route::get('/transactions/transfers', [App\Http\Controllers\Admin\TransactionController::class, 'transferList'])->name('admin.transactions.transfers.list');
        
        Route::match(['get', 'post'], '/transactions/edit/{id}', [App\Http\Controllers\Admin\TransactionController::class, 'edit'])->name('admin.transactions.edit');
        Route::match(['get', 'post'], '/transactions/edit/{id}', [App\Http\Controllers\Admin\TransactionController::class, 'edit'])->name('admin.transactions.edit');
        Route::post('/transactions/delete/{id}', [App\Http\Controllers\Admin\TransactionController::class, 'delete'])->name('admin.transactions.delete');
        
        //SMS
        Route::get('/sms', [App\Http\Controllers\Admin\SmsController::class, 'list'])->name('admin.sms.list');
        Route::match(['get', 'post'], '/sms/send', [App\Http\Controllers\Admin\SmsController::class, 'send'])->name('admin.sms.send');
        Route::match(['get', 'post'], '/sms/setting', [App\Http\Controllers\Admin\SmsController::class, 'setting'])->name('admin.sms.setting');
        
    });
    
});
