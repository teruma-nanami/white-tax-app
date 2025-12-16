<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\FilingController;
use App\Http\Controllers\DepreciationController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChatbotController;

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
	Route::get('/filing', [FilingController::class, 'index'])->name('filing.index');
	Route::get('/filing/{ledger}/entries-summary', [FilingController::class, 'show'])->name('filing.entries_summary');
	Route::get('/filing/{ledger}/deductions', [FilingController::class, 'create'])->name('filing.deductions.create');
	Route::post('/filing/{ledger}/deductions', [FilingController::class, 'store'])->name('filing.deductions.store');
	Route::get('/filing/{ledger}/deductions/edit', [FilingController::class, 'edit'])->name('filing.deductions.edit');
	Route::put('/filing/{ledger}/deductions', [FilingController::class, 'update'])->name('filing.deductions.update');
	Route::get('/filing/{ledger}/preview', [FilingController::class, 'preview'])->name('filing.preview');
	Route::get('/filing/{ledger}/depreciation', [DepreciationController::class, 'index'])->name('filing.depreciation.index');
	Route::get('/filing/{ledger}/depreciation/create', [DepreciationController::class, 'create'])->name('filing.depreciation.create');
	Route::post('/filing/{ledger}/depreciation', [DepreciationController::class, 'store'])->name('filing.depreciation.store');
	Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice.index');
	Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::get('/settings/ledger-status', [LedgerController::class, 'create'])->name('settings.ledger_status');
	Route::post('/settings/ledger-status', [LedgerController::class, 'store'])->name('settings.ledger_status.lock');
	Route::get('/categories/edit', [CategoryController::class, 'edit'])->name('categories.edit');
	Route::put('/categories', [CategoryController::class, 'update'])->name('categories.update');
});

Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot.index');
Route::post('/chatbot/message', [ChatbotController::class, 'message'])->name('chatbot.message');