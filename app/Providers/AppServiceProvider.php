<?php

namespace App\Providers;

use App\Models\Postingan;
use App\Policies\PostinganPolicy;
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
        // Daftarkan Policy — Laravel 12 tidak memerlukan AuthServiceProvider terpisah
        Gate::policy(Postingan::class, PostinganPolicy::class);
    }
}
