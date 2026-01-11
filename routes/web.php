<?php

use App\Livewire\KanbanBoard;
use App\Livewire\LandingPage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

// Landing Page (for guests)
Route::get('/{locale?}', LandingPage::class)
    ->middleware('guest')
    ->where('locale', 'ar')
    ->name('landing');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

// Language Switcher
Route::get('language/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'ar'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('language.switch');

// Dashboard (for authenticated users)
Route::get('/dashboard', KanbanBoard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('kanban', KanbanBoard::class)
    ->middleware(['auth', 'verified'])
    ->name('kanban');

Route::middleware(['auth'])->group(function () {
    // Settings routes removed - using modal instead
});
Route::post('/keep-alive', function () {
    return response()->json(['status' => 'alive']);
})->middleware('auth');
