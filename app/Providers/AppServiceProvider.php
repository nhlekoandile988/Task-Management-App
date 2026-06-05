<?php

namespace App\Providers;

use App\Models\TaskAKL;
use App\Observers\TaskObserverAN;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        TaskAKL::observe(TaskObserverAN::class);
    }
}

