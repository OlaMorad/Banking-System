<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
          $this->app->bind(
        \App\Modules\accounts\Repositories\BankAccountRepositoryInterface::class,
        \App\Modules\accounts\Repositories\BankAccountRepository::class
    );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
