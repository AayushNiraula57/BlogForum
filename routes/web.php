<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\TrashController;
use App\Http\Controllers\Admin\UnverifiedPostController;
use App\Http\Controllers\Admin\VerifiedPostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\User\AuthController as UserAuthController;
use App\Http\Controllers\User\PostController as UserPostController;
use App\Http\Controllers\User\UserBlogController;
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

Route::get('/', function () {
    return view('home');
});
Route::get('/blog', [UserPostController::class, 'index'])->name('blog.index')->middleware('2fa');
Route::get('/blog/{blogPost}', [UserPostController::class, 'show'])->name('blog.show')->middleware('2fa');



Route::middleware(['auth','2fa'])->group(function(){
Route::get('/blog/post/create', [UserPostController::class, 'create'])->name('blog.create');
Route::post('/blog/post/create', [UserPostController::class, 'store'])->name('blog.store');
Route::get('/blog/{blogPost}/edit', [UserPostController::class, 'edit'])->name('blog.edit');
Route::put('/blog/{blogPost}/edit', [UserPostController::class, 'update'])->name('blog.update');
Route::delete('/blog/{blogPost}', [UserPostController::class, 'destroy'])->name('blog.destroy');
Route::get('/blog/show/{id}', [UserBlogController::class, 'show'])->name('blog.manage_post');
Route::get('/blog/user/{blogPost}', [UserBlogController::class, 'index'])->name('blog.user_posts');
Route::get('signout', [UserAuthController::class, 'signout'])->name('signout');
});


Route::get('login', [UserAuthController::class, 'index'])->name('login');
Route::post('login', [UserAuthController::class, 'login'])->name('login.custom'); 
Route::get('registration', [UserAuthController::class, 'create'])->name('register_user');
Route::post('registration', [UsreAuthController::class, 'store'])->name('register.custom'); 

Route::prefix('admin')->group(function(){
    Route::get('login',[AdminAuthController::class,'index'])->name('admin.login');
    Route::post('custom-login',[AdminAuthController::class,'login'])->name('admin.login_custom');
    Route::get('registration',[AdminAuthController::class,'create'])->name('admin.registration')->middleware('auth.admin');
    Route::post('registration',[AdminAuthController::class,'store'])->name('admin.store')->middleware('auth.admin');
    Route::get('dashboard',[AdminPostController::class,'index'])->name('admin.dashboard')->middleware('auth.admin');
    Route::get('signout', [AdminAuthController::class, 'signout'])->name('admin.signout')->middleware('auth.admin');
});

Route::group(['prefix'=>'admin','middleware'=>'auth.admin'],function(){
    Route::get('show/{id}',[AdminPostController::class,'show'])->name('admin.show_post');
    Route::get('unverified',[UnverifiedPostController::class,'index'])->name('admin.show_unverified');
    Route::get('verified',[VerifiedPostController::class,'index'])->name('admin.show_verified');
    Route::get('verify/{id}',[UnverifiedPostController::class,'edit'])->name('admin.verify');
    Route::delete('user/{user}', [AdminAuthController::class, 'destroy'])->name('admin.user_destroy');
    Route::delete('post/{post}', [AdminPostController::class, 'destroy'])->name('admin.post_destroy');
    Route::get('post/trash/{id}', [TrashController::class, 'destroy'])->name('admin.post_trash');
    Route::get('trash', [TrashController::class, 'index'])->name('admin.trash');
    Route::get('restore/{post}', [TrashController::class, 'update'])->name('admin.post_restore');
});

Route::get('forget-password',[ForgotPasswordController::class,'index'])->name('forget_password.show');
Route::post('forget-password',[ForgotPasswordController::class,'store'])->name('forget_password.submit');
Route::get('reset-password/{token}',[ForgotPasswordController::class,'show'])->name('reset_password,show');
Route::post('reset-password',[ForgotPasswordController::class,'update'])->name('reset_password.submit');

Route::get('2fa', [App\Http\Controllers\TwoFAController::class, 'index'])->name('2fa.index');
Route::post('2fa', [App\Http\Controllers\TwoFAController::class, 'store'])->name('2fa.post');
Route::get('2fa/reset', [App\Http\Controllers\TwoFAController::class, 'update'])->name('2fa.resend');