<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\User\PostController as UserPostController;

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/post/{slug}', [PostController::class, 'show'])->name('post.show');
Route::get('/category/{slug}', [PostController::class, 'category'])->name('post.category');

Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

Route::prefix('user')->name('user.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [UserPostController::class, 'index'])->name('dashboard');
    Route::get('/posts/create', [UserPostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [UserPostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [UserPostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [UserPostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [UserPostController::class, 'destroy'])->name('posts.destroy');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/posts/search', [AdminPostController::class, 'search'])->name('posts.search');
    Route::get('/posts/pending', [AdminPostController::class, 'pending'])->name('posts.pending');
    Route::post('/posts/{post}/approve', [AdminPostController::class, 'approve'])->name('posts.approve');
    Route::post('/posts/{post}/reject', [AdminPostController::class, 'reject'])->name('posts.reject');
    Route::resource('posts', AdminPostController::class);
    Route::resource('categories', CategoryController::class);
});