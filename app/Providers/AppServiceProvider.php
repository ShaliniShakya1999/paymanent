<?php

namespace App\Providers;

use App\libraries\VerificationProviderManager;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use App\Models\TransactionType;
use App\Models\PaymentMethod;
use Modules\Virtualcard\Manager\ProviderManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('verificationprovidermanager', function () {
            return new VerificationProviderManager;
        });

        $this->app->singleton('virtualcardprovidermanager', function () {
            return new ProviderManager;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set default string length for database columns
        Schema::defaultStringLength(191);

        // Clear the X-Powered-By header for security reasons
        header('x-powered-by:');

        if (env('APP_INSTALL') == true) {

            if (Schema::hasTable('transaction_types')) {
                $transactionTypes = TransactionType::all()->toArray();

                foreach ($transactionTypes as $transactionType) {
                    if (!defined($transactionType['name'])) {
                        define($transactionType['name'], $transactionType['id']);
                    }
                }
            }

            if (Schema::hasTable('payment_methods')) {
                $paymentMethods = PaymentMethod::all()->toArray();

                foreach ($paymentMethods as $paymentMethod) {
                    if (!defined($paymentMethod['name'])) {
                        define($paymentMethod['name'], $paymentMethod['id']);
                    }
                }
            }

            $adminUrlPrefix = preference('admin_url_prefix');
            if (!empty($adminUrlPrefix)) {
                Config::set(['adminPrefix' => $adminUrlPrefix]);
                View::share('adminPrefix', $adminUrlPrefix);
            }
        }
    }
}
