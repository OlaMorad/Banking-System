<?php

namespace App\Providers;

use App\Modules\Transactions\Integrations\PaymentGateway;
use App\Modules\Transactions\Integrations\StripeAdapter;
use App\Modules\Transactions\Repositories\TransactionRepository;
use App\Modules\Transactions\Repositories\TransactionRepositoryInterface;
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
        $this->app->bind(
            TransactionRepositoryInterface::class,
            TransactionRepository::class
        );
        $this->app->bind(
            PaymentGateway::class,
            StripeAdapter::class
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
