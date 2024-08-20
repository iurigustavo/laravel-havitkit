<?php

use App\Livewire\Auth\Login;
use App\Livewire\MyProfile;
use App\Livewire\Settings\Roles\Create;
use App\Livewire\Settings\Roles\Edit;
use App\Livewire\Settings\Roles\Index;
use App\Livewire\Welcome;
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
Route::get('/login', Login::class)->name('login');
Route::get('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
});

Route::middleware('auth')->group(function () {
    Route::get('/', Welcome::class)->name('home');
    Route::get('my-profile', MyProfile::class)->name('my-profile');
    Route::impersonate();

    Route::prefix('management')->name('management.')->group(function () {
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', \App\Livewire\Settings\Users\Index::class)->name('index');
            Route::get('/create', \App\Livewire\Settings\Users\Create::class)->name('create');
            Route::get('/{user}', \App\Livewire\Settings\Users\Edit::class)->name('show');
        });
        Route::prefix('roles')->name('roles.')->group(function () {
            Route::get('/', Index::class)->name('index');
            Route::get('/create', Create::class)->name('create');
            Route::get('/{role}', Edit::class)->name('show');
        });
        Route::prefix('permissions')->name('permissions.')->group(function () {
            Route::get('/', App\Livewire\Settings\Permissions\Index::class)->name('index');
            Route::get('/create', App\Livewire\Settings\Permissions\Create::class)->name('create');
            Route::get('/{permission}', App\Livewire\Settings\Permissions\Edit::class)->name('show');
        });

        Route::get('/activity-log', App\Livewire\Settings\ActivityLog\Index::class)->name('activity-log.index');
    });
});
