<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\CategoryArticleController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\CycleRecordController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Route;
// Frontend
use App\Http\Controllers\Frontend\CycleRecordController as FrontendCycleRecordController;
use App\Http\Controllers\Frontend\ArticleController as FrontendArticleController;
use App\Http\Controllers\HomeController;

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
});

Route::get('/about-us', function () {
    return view('frontend.about-us');
})->name('about-us');

Route::get('/terms-condition', function () {
    return view('frontend.terms-condition');
})->name('terms');

Route::get('/article-general', function () {
    return view('frontend.article-general');
})->name('article-general');

// user routes
Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::get('/home', function () {
        return view('frontend.home');
    })->name('home');

    Route::get('/profile/{id}', [ProfileController::class, 'card'])->name('profile');
    Route::get('/profile/fill/{id}', [ProfileController::class, 'fillProfile'])->name('profile.fill');
    Route::get('/profile/edit/{id}', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/change-password', [ChangePasswordController::class, 'showChangePasswordForm'])->name('custom.password.change');
    Route::put('/change-password', [ChangePasswordController::class, 'changePassword'])->name('custom.password.update');

    Route::resource('cycle-record', FrontendCycleRecordController::class);
    Route::get('cycle-record/show/{id}/pdf', [FrontendCycleRecordController::class, 'generateShowPdf'])->name('cycle-record.pdf');
    Route::get('cycle-record/pdf/index', [FrontendCycleRecordController::class, 'generateIndexPdf'])->name('cycle-record.index.pdf');
    Route::get('cycle-record/{id}/delete', [FrontendCycleRecordController::class, 'destroy'])->name('cycle-record.delete');

    Route::resource('article', FrontendArticleController::class);
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

    Route::resource('/', HomeController::class);

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


require __DIR__.'/auth.php';
