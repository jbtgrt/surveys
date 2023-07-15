<?php
namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use App\Auth\AdminAuthGuard;
use Illuminate\Support\ServiceProvider;

class AdminAuthProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {  
        Auth::provider('admin', function ($app, array $config) {
            return new AdminAuthGuard();
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}