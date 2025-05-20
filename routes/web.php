<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
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



Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// Home and static pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Blog routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::post('/blog/{slug}/comment', [BlogController::class, 'comment'])->name('blog.comment')->middleware('auth');


// Forum routes
Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
Route::get('/forum/create', [ForumController::class, 'create'])->name('forum.create')->middleware('auth');
Route::post('/forum', [ForumController::class, 'store'])->name('forum.store')->middleware('auth');
Route::get('/forum/{slug}', [ForumController::class, 'show'])->name('forum.show');
Route::post('/forum/{slug}/comment', [ForumController::class, 'comment'])->name('forum.comment')->middleware('auth');
Route::post('/forum/{id}/like', [ForumController::class, 'like'])->name('forum.like')->middleware('auth');
Route::post('/comment/{id}/like', [ForumController::class, 'likeComment'])->name('comment.like')->middleware('auth');

// AI Chat routes
Route::get('/chat', [ChatController::class, 'createSession'])->name('chat.create');
Route::get('/chat/{slug}', [ChatController::class, 'show'])->name('chat.show');
Route::post('/chat/{slug}/message', [ChatController::class, 'storeMessage'])->name('chat.message');

// Gemini advanced features
Route::post('/gemini/multiturn/{slug}', [\App\Http\Controllers\ChatController::class, 'multiTurnChat']);
Route::post('/gemini/stream/{slug}', [\App\Http\Controllers\ChatController::class, 'streamStory']);
Route::post('/gemini/structured/{slug}', [\App\Http\Controllers\ChatController::class, 'structuredOutput']);
Route::post('/gemini/save-info', [\App\Http\Controllers\ChatController::class, 'saveUserInfo']);
Route::get('/gemini/get-info', [\App\Http\Controllers\ChatController::class, 'getUserInfo']);




// Authentication routes (Laravel Breeze provides these)
require __DIR__.'/auth.php';
// require __DIR__.'/auth.php';