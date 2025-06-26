<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GameRequestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/teste', function () {
    return response()->json(['mensagem' => 'API funcionando']);
});

Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/followers/{user_id}', [UserController::class, 'followers'])->name('user.followers');
Route::get('/following/{user_id}', [UserController::class, 'following'])->name('user.following');
Route::get('/user/{user_id}', [UserController::class, 'show'])->name('user.show');
Route::post('/user/{user_id}/ban', [UserController::class, 'ban'])->name('user.ban');
Route::delete('/user/{user_id}', [UserController::class, 'destroy'])->name('user.destroy');
Route::post('/user/follow', [UserController::class, 'follow'])->name('user.follow');
Route::post('/user/{user_id}',  [UserController::class, 'update'])->name('user.update');
Route::get('/user/{user_id}/library', [UserController::class, 'get_libraries'])->name('user.library');
Route::get('/user/{user_id}/review', [UserController::class, 'get_reviews'])->name('user.reviews');
Route::get('/user/{user_id}/comment', [UserController::class, 'get_comments'])->name('user.comments');

Route::post('/library', [LibraryController::class, 'store'])->name('library.store');
Route::delete('/library/{library_id}', [LibraryController::class, 'destroy'])->name('library.destroy');
Route::post('/library/{library_id}/add_game/{game_id}', [LibraryController::class, 'add_game'])->name('library.add_game');
Route::delete('/library/{library_id}/remove_game/{game_id}', [LibraryController::class, 'remove_game'])->name('library.remove_game');
Route::get('/library/{library_id}', [LibraryController::class, 'get_games'])->name('library.get_games');

Route::post('/review', [ReviewController::class, 'store'])->name('review.store');
Route::delete('/review/{review_id}', [ReviewController::class, 'destroy'])->name('review.destroy');

Route::get('/comment/{parent_id}/{parent_type}', [CommentController::class, 'show'])->name('comment.show');
Route::post('/comment', [CommentController::class, 'store'])->name('comment.store');
Route::delete('/comment/{comment_id}', [CommentController::class, 'destroy'])->name('comment.destroy');

Route::post('/game_request', [GameRequestController::class, 'store'])->name('game_request.store');
Route::post('/game_request/{game_request_id}', [GameRequestController::class, 'handle'])->name('game_request.handle');
Route::get('/game_request', [GameRequestController::class, 'index'])->name('game_request.index');
Route::delete('/game_request/{game_request_id}', [GameRequestController::class, 'destroy'])->name('game_request.destroy');

Route::post('/report', [ReportController::class, 'store'])->name('report.store');
Route::post('/report/{report_id}', [ReportController::class, 'handle'])->name('report.handle');
Route::get('/report', [ReportController::class, 'index'])->name('report.index');
Route::delete('/report/{report_id}', [ReportController::class, 'destroy'])->name('report.destroy');

Route::get('/game/{game_id}/reviews', [GameController::class, 'reviews'])->name('game.reviews');
Route::get('/game/search/{search_term}', [GameController::class, 'search'])->name('games.search');
Route::get('/game/{game_id}', [GameController::class, 'show'])->name('game.show');
Route::post('/game', [GameController::class, 'store'])->name('game.store');
Route::delete('/game/{game_id}', [GameController::class, 'destroy'])->name('game.destroy');

Route::get('/home/{user_id}', [HomeController::class, 'index'])->name('home');
