<?php

use Livewire\Volt\Volt;

Volt::route('/', 'home')->middleware('auth')->name('home');

Route::prefix('/user')->middleware('auth')->group(function () {
	Volt::route('/create', 'user-form')->name('user-create');
	Volt::route('/{member}/edit', 'user-form')->name('user-edit');
});

Route::view('dashboard', 'dashboard')
	->middleware(['auth', 'verified'])
	->name('dashboard');

Route::middleware(['auth'])->group(function () {
	Route::redirect('settings', 'settings/profile');

	Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
	Volt::route('settings/password', 'settings.password')->name('settings.password');
	Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__ . '/auth.php';
