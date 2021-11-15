<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\User;
use App\TwoStepAuthTable;
use App\Observers\TwoStepAuthTableObserver;
use jeremykenedy\laravel2step\App\Models\TwoStepAuth;

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
        //

        view()->composer('layouts.admin', function ($view) {
            $view->with('notifications', auth()->user()->unreadNotifications()->groupBy('notifiable_type')->count());
            $view->with('notificationDescription', auth()->user()->unreadNotifications()->take(7)->get());
        });

        //observers to send OTP code to the client
        TwoStepAuth::observe(TwoStepAuthTableObserver::class);
    }
}
