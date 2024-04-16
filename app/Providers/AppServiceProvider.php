<?php

namespace App\Providers;

/* use Illuminate\Support\ServiceProvider; */
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot(): void
    {
        //
        $this->registerPolicies();

        Gate::define('delete', function ($user, $role) {
        return $user->hasRole('super-admin');
    });
    }
}
