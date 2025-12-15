<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntryController;

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

// Email verification routes removed — this template does not require email verification.

// Home
Route::middleware('auth')->group(function () {
	Route::get('/', [DashboardController::class, 'index'])->name('dashboard.home');
	Route::get('/notifications', [DashboardController::class, 'notifications'])->name('dashboard.notifications');
	Route::get('/entries', [EntryController::class, 'index'])->name('entries.index');
	Route::get('/entries/create', [EntryController::class, 'create'])->name('entries.create');
	Route::post('/entries/create', [EntryController::class, 'store'])->name('entries.store');
	Route::get('/entries/{entry}/edit', [EntryController::class, 'edit'])->name('entries.edit');
	Route::put('/entries/{entry}', [EntryController::class, 'update'])->name('entries.update');
	Route::get('/entries/categories', [EntryController::class, 'categories'])->name('entries.categories');
	Route::get('/entries/capitalized', [EntryController::class, 'capitalized'])->name('entries.capitalized');
});