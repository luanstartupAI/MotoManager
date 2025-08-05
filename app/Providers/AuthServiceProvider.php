<?php

namespace App\Providers;

use App\Models\Customer;
use App\Models\Lead;
use App\Models\Motorcycle;
use App\Models\Sale;
use App\Policies\CustomerPolicy;
use App\Policies\LeadPolicy;
use App\Policies\MotorcyclePolicy;
use App\Policies\SalePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Customer::class => CustomerPolicy::class,
        Motorcycle::class => MotorcyclePolicy::class,
        Lead::class => LeadPolicy::class,
        Sale::class => SalePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define gates for dashboard access
        Gate::define('view_dashboard', function ($user) {
            return $user->can('view_dashboard');
        });

        Gate::define('manage_users', function ($user) {
            return $user->can('manage_users');
        });
    }
}

