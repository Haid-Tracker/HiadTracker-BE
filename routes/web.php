<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\CycleRecordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Route;

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

Route::get('/test', function () {
    return view('frontend.auth.verify-email');
});

Route::get('/', function () {
    if (auth()->check()) {
        $role = auth()->user()->getRoleNames()->first();
        if ($role === 'user') {
            return redirect()->route('home');
        } elseif ($role === 'admin' || $role === 'super-admin') {
            return redirect()->route('admin.home');
        }
    }
    return view('frontend.welcome');
})->name('welcome');


// user routes
Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::get('/home', function () {
        return view('frontend.home');
    })->name('home');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit/{id}', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // buatan genta ganteng
    Route::get('/change-password', [ChangePasswordController::class, 'showChangePasswordForm'])->name('custom.password.change');
    Route::put('/change-password', [ChangePasswordController::class, 'changePassword'])->name('custom.password.update');

});

// admin routes
Route::prefix('admin')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])
            ->name('admin.login');
        Route::post('/login', [AdminAuthController::class, 'login'])
            ->name('admin.login.submit');
    });

    Route::middleware(['auth', 'role:admin|super-admin'])->group(function () {
        Route::get('/', function () {
            return view('backend.home');
        })->name('admin.home');
    });
});

Route::group(['middleware' => ['role:super-admin|admin']], function() {

    Route::resource('permissions', App\Http\Controllers\PermissionController::class);
    Route::get('permissions/{permissionId}/delete', [App\Http\Controllers\PermissionController::class, 'destroy']);

    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::get('roles/{roleId}/delete', [App\Http\Controllers\RoleController::class, 'destroy']);

    Route::get('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'addPermissionToRole']);
    Route::put('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'givePermissionToRole']);

    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::get('users/{userId}/delete', [App\Http\Controllers\UserController::class, 'destroy']);

    Route::resource('user-profiles', App\Http\Controllers\UserProfileController::class);
    Route::get('user-profiles/{id}/delete', [App\Http\Controllers\UserProfileController::class, 'destroy']);

    //cycle record
    Route::get('user/cycle-record', [CycleRecordController::class, 'index'])->name('user.cycle-record');
    Route::get('user/cycle-record/edit/{userId}', [CycleRecordController::class, 'edit'])->name('user.cycle-record.edit');
    Route::put('user/cycle-record/update/{userId}', [CycleRecordController::class, 'update'])->name('user.cycle-record.update');
    Route::delete('user/cycle-record/delete/{userId}', [CycleRecordController::class, 'destroy'])->name('user.cycle-record.destroy');
});


require __DIR__.'/auth.php';
