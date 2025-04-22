<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\LoanRepository;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    // AppServiceProvider.php
    public function register()
    {
         $this->app->bind(LoanRepository::class);
    }    

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
