<?php

use Livewire\Volt\Volt;
use function Pest\Laravel\artisan;

Volt::route('/', 'home')->name('home');

Route::get('/1', function () {
	Artisan::call('migrate:fresh');
	Artisan::call('db:seed');
	return 'done';
});

Route::prefix('/user')->group(function () {
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
