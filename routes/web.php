<?php

use App\Livewire\KanbanBoard;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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

Route::get('/', KanbanBoard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::redirect('dashboard', '/');

Route::get('kanban', KanbanBoard::class)
    ->middleware(['auth', 'verified'])
    ->name('kanban');

Route::middleware(['auth'])->group(function () {
    // Settings routes removed - using modal instead
});
