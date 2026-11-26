<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\Userzone\ApproveCommentController;
use App\Http\Controllers\Userzone\DashboardController;
use App\Http\Controllers\Userzone\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;

/*
 * Public Website routes
 */
Route::get('/', WelcomeController::class)->name('welcome');

Route::resource('trips', TripController::class)->only(['index', 'show']);
Route::resource('places', PlaceController::class)->only(['show']);
Route::resource('categories', CategoryController::class)->only(['index', 'show']);

// a comment belongs to a trip: /trips/{trip}/comments (only logged in users may comment)
Route::resource('trips.comments', CommentController::class)->only(['store'])->middleware('auth');

/*
 * Authentication routes
 */
require __DIR__.'/auth.php';

/*
 * Userzone routes
 */
Route::middleware('auth')->group(function () {
    // For the user's dashboard (after login)
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // Normal user routes here ------------------------------------------------------------------
    Route::prefix('user')->name('userzone.')->group(function () {
        Route::resource('trips', App\Http\Controllers\Userzone\TripController::class)->except('show');
        Route::resource('places', App\Http\Controllers\Userzone\PlaceController::class)->except('show');
        // moderation of comments: no create/store (comments are posted on the trip page)
        Route::resource('comments', App\Http\Controllers\Userzone\CommentController::class)->except(['create', 'store']);
        // approving is not a CRUD action: one POST route, one single-action controller
        Route::post('comments/{id}/approve', ApproveCommentController::class)->name('comments.approve');
    });

    // Admin user routes -------------------------------------------------------------------------
    Route::prefix('user')->name('userzone.')->middleware(IsAdmin::class)->group(function () {
        Route::resource('categories', App\Http\Controllers\Userzone\CategoryController::class)->except('show');
    });

    // For the user's profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Resource action	Controller method	Purpose
//     index            index()         Show all trips
//     create	        create()        Show the create form
//     store	        store()         Save a new trip
//     show	            show()          Show one trip
//     edit	            edit()          Show the edit form
//     update	        update()        Save changes
//     destroy	        destroy()       Delete a trip

// we can use custom controller method names
// but for Route:resource(), Laravel expects standard resource method names

// The rule is:
//  - Route::resource() → follow Laravel's standard resource method names.
//  - Route::get() / Route::post() etc. → you can specify your own controller method name.
