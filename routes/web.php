<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\CategoryArticleController;
use App\Http\Controllers\CycleRecordController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Route;
// Frontend
use App\Http\Controllers\Frontend\CycleRecordController as FrontendCycleRecord;

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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
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

Route::group(['middleware' => ['role:super-admin|admin'], 'prefix' => 'admin', 'as' => 'admin.'], function() {

    Route::resource('permissions', PermissionController::class);
    Route::get('permissions/{permissionId}/delete', [PermissionController::class, 'destroy'])->name('permissions.delete');

    Route::resource('roles', RoleController::class);
    Route::get('roles/{roleId}/delete', [RoleController::class, 'destroy'])->name('roles.delete');

    Route::get('roles/{roleId}/give-permissions', [RoleController::class, 'addPermissionToRole'])->name('roles.give-permissions');
    Route::put('roles/{roleId}/give-permissions', [RoleController::class, 'givePermissionToRole'])->name('roles.give-permissions.update');

    Route::resource('users', UserController::class);
    Route::get('users/{userId}/delete', [UserController::class, 'destroy'])->name('users.delete');

    Route::resource('user-profiles', UserProfileController::class);
    Route::get('user-profiles/{id}/delete', [UserProfileController::class, 'destroy'])->name('user-profiles.delete');

    Route::resource('articles', ArticleController::class);
    Route::get('/articles/{id}/preview', [ArticleController::class, 'preview'])->name('articles.preview');
    Route::get('articles/{id}/delete', [ArticleController::class, 'destroy'])->name('articles.delete');

    Route::resource('category-article', CategoryArticleController::class);
    Route::get('category-article/{id}/delete', [CategoryArticleController::class, 'destroy'])->name('category-article.delete');

    Route::get('cycle-record', [CycleRecordController::class, 'index'])->name('cycle-record');
    Route::get('cycle-record/show/{id}', [CycleRecordController::class, 'show'])->name('cycle-record.show');
    Route::get('cycle-record/edit/{userId}', [CycleRecordController::class, 'edit'])->name('cycle-record.edit');
    Route::put('cycle-record/update/{userId}', [CycleRecordController::class, 'update'])->name('cycle-record.update');
    Route::delete('cycle-record/delete/{userId}', [CycleRecordController::class, 'destroy'])->name('cycle-record.destroy');
    Route::get('cycle-record/create', [CycleRecordController::class, 'create'])->name('cycle-record.create');
    Route::post('cycle-record/store', [CycleRecordController::class, 'store'])->name('cycle-record.store');
});

// user
Route::middleware(['auth'])->group(function () {
    Route::resource('cycle-record', FrontendCycleRecord::class);
    Route::get('cycle-record/{id}/delete', [FrontendCycleRecord::class, 'destroy'])->name('cycle-record.delete');

});


require __DIR__.'/auth.php';
