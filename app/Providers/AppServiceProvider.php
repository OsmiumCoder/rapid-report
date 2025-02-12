<?php

namespace App\Providers;

use App\Policies\DashboardPolicy;
use App\Policies\ReportPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Vite;
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
        Vite::prefetch(concurrency: 3);

        Gate::define('view-report-page', [ReportPolicy::class, 'view']);

        Gate::define('view-admin-overview', [DashboardPolicy::class, 'viewAdminOverview']);
        Gate::define('view-supervisor-overview', [DashboardPolicy::class, 'viewSupervisorOverview']);
        Gate::define('view-user-management', [DashboardPolicy::class, 'viewUserManagement']);

    }
}
