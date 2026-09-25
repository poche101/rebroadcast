<?php

use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\PrayerRequestController;
use App\Http\Controllers\Admin\RebroadcastController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\RebroadcastPublicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest — login / registration. The whole platform is members-only.
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Public (members-only) — the worship / rebroadcast experience
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/', [RebroadcastPublicController::class, 'show'])->name('rebroadcast.show');
    Route::post('/prayer-requests', [RebroadcastPublicController::class, 'submitPrayer'])->name('prayer-requests.store');

    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

    Route::post('/presence/ping', [PresenceController::class, 'ping'])->name('presence.ping');
    Route::get('/presence/{rebroadcast}', [PresenceController::class, 'list'])->name('presence.list');
});

/*
|--------------------------------------------------------------------------
| Admin console — auth + admin role required
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::redirect('/', '/admin/rebroadcasts');

    Route::resource('rebroadcasts', RebroadcastController::class)->except('show');

    Route::get('prayer-requests', [PrayerRequestController::class, 'index'])->name('prayer-requests.index');
    Route::patch('prayer-requests/{prayerRequest}/status', [PrayerRequestController::class, 'updateStatus'])
        ->name('prayer-requests.update-status');

    Route::get('comments', [AdminCommentController::class, 'index'])->name('comments.index');
    Route::post('comments', [AdminCommentController::class, 'store'])->name('comments.store');
    Route::delete('comments/{comment}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');
});
