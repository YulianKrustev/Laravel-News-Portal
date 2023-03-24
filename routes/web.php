<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Backend\CategoryController;

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

Route::get('/', [IndexController::class, 'Index']);

Route::middleware(['auth'])->group(function() {

    Route::get('/dashboard', [UserController::class, 'UserDashboard'])->name('dashboard');
    Route::post('/user/profile/store', [UserController::class, 'UserProfileUpdate'])->name('user.profile.store');
    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::get('/change/password', [UserController::class, 'ChangePassword'])->name('change.password');
    Route::post('/change/password', [UserController::class, 'UserChangePassword'])->name('user.change.password');

    }); // End Admin Middleware

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';

Route::middleware(['auth','role:admin'])->group(function() {

// Admin all Routes
Route::controller(AdminController::class)->group(function(){
Route::get('/admin/dashboard','AdminDashboard')->name('admin.dashboard');
Route::get('/admin/loguot','AdminLogout')->name('admin.logout');
Route::get('/admin/profile','AdminProfile')->name('admin.profile');
Route::post('/admin/profile/store','AdminProfileStore')->name('admin.profile.store');
Route::get('/admin/change/password','AdminChangePassword')->name('admin.change.password');
Route::post('/admin/update/password','AdminUpdatePassword')->name('admin.update.password');
});

}); // End Admin Middleware

Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->middleware(RedirectIfAuthenticated::class)->name('admin.login');

Route::get('/admin/logout/page', [AdminController::class, 'AdminLogoutPage'])->name('admin.logout.page');




Route::middleware(['auth','role:admin'])->group(function() {

// Category all Routes
Route::controller(CategoryController::class)->group(function(){

Route::get('/all/category','AllCategory')->name('all.category');
Route::get('/add/category','AddCategory')->name('add.category');

});

}); // End Admin Middleware