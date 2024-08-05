<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });

        Builder::macro('pluckWithIdName', function ($idColumn = null, $nameColumn = null): Collection {
            return $this->pluck($idColumn, $nameColumn)->mapWithKeys(fn($id, $value) => [$id => ['id' => $id, 'name' => $value]]);
        });
    }
}
