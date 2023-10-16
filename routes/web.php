<?php

use App\Http\Controllers\AdminAuth\AdminController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ProfileController;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
        Route::get('/profile/feedback/userListing', 'userListing')->name('feedback.userListing');

    });
    Route::controller(FeedbackController::class)->group(function () {
        Route::get('/feedback/listing', 'index')->name('feedback.index');
        Route::get('/feedback/create', 'create')->name('feedback.create');
        Route::get('/feedback/view/{id}', 'view')->name('feedback.view');
        Route::post('/feedback/store', 'store')->name('feedback.store');
        Route::post('/feedback/voteStatus', 'voteStatus')->name('feedback.voteStatus');
        Route::post('/feedback/comment',  'comment')->name('feedback.comment');

    });
});

// admin routes

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth:admin', 'verified'])->name('admin.dashboard');
Route::middleware(['auth:admin'])->group(function () {
    Route::prefix('admin')->controller(AdminController::class)->group(function () {
        Route::get('/feedback/listing', 'index')->name('admin.feedback.index');
        Route::get('/feedback/view/{id}', 'view')->name('admin.feedback.view');
        Route::get('/feedback/edit/{id}', 'edit')->name('admin.feedback.edit');
        Route::post('/feedback/update', 'update')->name('admin.feedback.update');
        Route::post('/feedback/destroy/{id}', 'destroy')->name('admin.feedback.destroy');
        Route::post('/feedback/comment/destroy/{id}', 'commentDestroy')->name('admin.feedback.comment.delete');

    });

});
require __DIR__.'/auth.php';
require __DIR__.'/adminauth.php';
