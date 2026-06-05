<?php

namespace App\Providers;

use App\Models\TaskAKL;
use App\Models\CategoryAKL;
use App\Models\User;
use App\Policies\TaskPolicyAKL;
use App\Policies\CategoryPolicyAKL;
use App\Policies\UserPolicyAKL;
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
        TaskAKL::class => TaskPolicyAKL::class,
        CategoryAKL::class => CategoryPolicyAKL::class,
        User::class => UserPolicyAKL::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manage-users-akl', fn ($user) => $user->role === 'admin');
    }
}

