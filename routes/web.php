<?php

use App\Http\Controllers\Admin\AuthorVerificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VoteController;
use App\Services\Interfaces\PostServiceInterface;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function (PostServiceInterface $postService) {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'posts' => $postService->getAllPosts(11), // 1 for hero + 10 for grid/pagination
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['auth', 'verified_author'])->group(function () {
        Route::post('posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');
        Route::delete('posts/{id}/force-delete', [PostController::class, 'forceDelete'])->name('posts.force-delete');
        Route::resource('posts', PostController::class)->except(['index', 'show']);
    });

    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/verify-authors', [AuthorVerificationController::class, 'index'])->name('verify-authors.index');
        Route::post('/verify-authors/{user}/verify', [AuthorVerificationController::class, 'verify'])->name('verify-authors.verify');
    });
});

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');
Route::post('/posts/{post}/vote', [VoteController::class, 'vote'])->name('posts.vote');

require __DIR__.'/auth.php';
