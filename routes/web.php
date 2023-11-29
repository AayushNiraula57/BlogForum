<?php

use App\Http\Controllers\AdminBlogController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogPostController;
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
Route::get('/blog', [BlogPostController::class, 'index'])->name('blog.index');
Route::get('/blog/{blogPost}', [BlogPostController::class, 'show'])->name('blog.show');



Route::middleware('auth')->group(function(){
Route::get('/blog/create/post', [BlogPostController::class, 'create'])->name('blog.create');
Route::post('/blog/create/post', [BlogPostController::class, 'store'])->name('blog.store');
Route::get('/blog/{blogPost}/edit', [BlogPostController::class, 'edit'])->name('blog.edit');
Route::put('/blog/{blogPost}/edit', [BlogPostController::class, 'update'])->name('blog.update');
Route::get('/blog/show/{id}', [BlogPostController::class, 'showUserPost'])->name('blog.user.show');
Route::delete('/blog/{blogPost}', [BlogPostController::class, 'destroy'])->name('blog.destroy');
Route::get('/blog/manage/{blogPost}', [BlogPostController::class, 'managePost'])->name('blog.manage_post');
Route::get('signout', [AuthController::class, 'signOut'])->name('signout');
});


// Route::get('dashboard', [AuthController::class, 'dashboard']); 
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('custom-login', [AuthController::class, 'customLogin'])->name('login.custom'); 
Route::get('registration', [AuthController::class, 'registration'])->name('register_user');
Route::post('custom-registration', [AuthController::class, 'customRegistration'])->name('register.custom'); 

Route::prefix('admin')->group(function(){
    Route::get('login',[AdminController::class,'index'])->name('admin.login');
    Route::post('custom-login',[AdminController::class,'login'])->name('admin.login_custom');
    Route::get('registration',[AdminController::class,'registration'])->name('admin.registration');
    Route::post('registration',[AdminController::class,'registerAdmin'])->name('admin.store');
    Route::get('dashboard',[AdminBlogController::class,'dashboard'])->name('admin.dashboard')->middleware('auth.admin');
    Route::get('signout', [AdminController::class, 'signOut'])->name('admin.signout')->middleware('auth.admin');
});

Route::group(['prefix'=>'admin','middleware'=>'auth.admin'],function(){
    Route::get('show/unverified',[AdminBlogController::class,'displayUnverifiedPosts'])->name('admin.show_unverified');
    Route::get('show/verified',[AdminBlogController::class,'displayVerifiedPosts'])->name('admin.show_verified');
    Route::get('verify/{id}',[AdminBlogController::class,'verifyPosts'])->name('admin.verify');
    Route::get('posts/manage',[AdminBlogController::class,'managePosts'])->name('admin.manage');
    Route::delete('user/{user}', [AdminBlogController::class, 'destroyUser'])->name('admin.user_destroy');
    Route::get('post/{post}', [AdminBlogController::class, 'destroyPost'])->name('admin.post_destroy');
    Route::get('trash', [AdminBlogController::class, 'trash'])->name('admin.trash');
    Route::get('restore/{post}', [AdminBlogController::class, 'restore'])->name('admin.post_restore');
});