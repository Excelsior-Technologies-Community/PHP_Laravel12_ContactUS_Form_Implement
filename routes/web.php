<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Customer routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact.form');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/contact/tracking', [ContactController::class, 'trackingForm'])->name('contact.tracking.form');
Route::get('/contact/tracking/{id}', [ContactController::class, 'tracking'])->name('contact.tracking');

// Admin routes (Breeze login)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/contacts', [ContactController::class, 'adminIndex'])->name('admin.contacts');
    Route::get('/admin/contacts/{contact}', [ContactController::class, 'show'])->name('admin.contacts.show');
    Route::post('/admin/contacts/{contact}/reply', [ReplyController::class, 'store'])->name('admin.contacts.reply');
    Route::delete('/admin/contacts/{contact}/reply/{reply}', [ReplyController::class, 'destroy'])->name('admin.contacts.reply.destroy');
    Route::post('/admin/contacts/{contact}/status', [ContactController::class, 'updateStatus'])->name('admin.contacts.status');
});

// Default routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
