<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostIgController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;


date_default_timezone_set('Asia/Jakarta');

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

Route::get('/', function () {
    return json_encode([
        'postIg' => 'IG Posh',
        'time' => Carbon::now(),
    ]);
});

// {{url}}/api/v1
// No Authorization
Route::post('v1/login', [AuthController::class, 'login']);
Route::post('v1/ubah-password', [AuthController::class, 'ubahPassword']);

// With Authorization
Route::middleware(['jwt.verify'])
    ->prefix('v1')
    ->name('v1.')
    ->group(function () {
        // Auth
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('get-user', [AuthController::class, 'getUser']);
      
        // Menu Transaksi
        Route::get('menu-user/permission', [
            MenuController::class,
            'permission',
        ])->name('menu-user/permission');
        Route::get('menu-user', [MenuController::class, 'index'])->name(
            'menu-user'
        );
        Route::post('createMenuUser', [
            MenuController::class,
            'CreateMenuUser',
        ])->name('createMenuUser');
        Route::put('upMenu/{id?}', [MenuController::class, 'UpMenu']);
        Route::put('downMenu/{id?}', [MenuController::class, 'DownMenu']);
        Route::delete('menu-user-hapus/{id?}', [
            MenuController::class,
            'HapusMenuUser',
        ]);
        // Menu Master
        Route::get('menu', [MenuController::class, 'ResolveAll'])->name('menu');
        Route::get('menu/all', [MenuController::class, 'getAllMenu'])->name(
            'menu/all'
        );
        Route::get('menu/id', [MenuController::class, 'getAllMenuId'])->name(
            'menu/id'
        );
        Route::post('createMenu', [MenuController::class, 'CreateMenu'])->name(
            'createMenu'
        );
        Route::put('updateMenu/{id?}', [MenuController::class, 'UpdateMenu']);
        Route::delete('menu-hapus/{id?}', [MenuController::class, 'HapusMenu']);
        // User
        Route::get('users', [UserController::class, 'ResolveAll'])->name(
            'users'
        ); Route::get('users-all-gudang', [UserController::class, 'getAllUserGudang'])->name(
            'users-all-gudang'
        );
        Route::get('users/{id?}', [UserController::class, 'getAllUserId']);

        Route::get('users-all', [UserController::class, 'getAll']);
        Route::post('users-create', [
            UserController::class,
            'CreateUser',
        ])->name('users-create');
        Route::put('users-update/{id?}', [UserController::class, 'UpdateUser']);
        Route::delete('users-delete/{id?}', [
            UserController::class,
            'DeleteUser',
        ]);
        Route::put('users/password/reset/{id?}', [
            UserController::class,
            'ResetPassword',
        ]);
        // Role
        Route::get('roles', [RoleController::class, 'ResolveAll'])->name(
            'roles'
        );
        Route::get('roles/{id?}', [RoleController::class, 'getAllRoleId']);

        Route::get('roles-all', [RoleController::class, 'getAll']);
        Route::post('roles-create', [
            RoleController::class,
            'CreateRole',
        ])->name('roles-create');
        Route::put('roles-update/{id?}', [RoleController::class, 'UpdateRole']);
        Route::delete('roles-delete/{id?}', [
            RoleController::class,
            'DeleteRole',
        ]);

     // PostIg
    Route::get('postIg', [PostIgController::class, 'index'])->name('postIg');
    Route::get('postIg/all', [PostIgController::class, 'getAll'])->name('postIg/all');
    Route::post('postIg', [PostIgController::class, 'store'])->name('postIg');
    Route::get('postIg/{id?}', [PostIgController::class, 'show']);
    Route::post('update-postIg', [PostIgController::class, 'update']);
    Route::delete('postIg/{id?}', [PostIgController::class, 'destroy']);
});
