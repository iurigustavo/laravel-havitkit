<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\URL;
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
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
            URL::forceRootUrl(config('app.url'));
        }

        Builder::macro('pluckWithIdName', fn ($idColumn = null, $nameColumn = null): Collection => $this->pluck($nameColumn, $idColumn)->map(fn ($value, $id): array => ['id' => $id, 'name' => $value])->values());
    }
}
