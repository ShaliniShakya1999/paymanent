<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CurrencyPaymentMethodsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('currency_payment_methods')->delete();
        
        DB::table('currency_payment_methods')->insert([
            [
                'currency_id' => getCurrencyId('USD'),
                'method_id' => getPaymentMethodId('Stripe'),
                'activated_for' => '{"deposit":""}',
                'method_data' => '{"secret_key":"","publishable_key":""}',
                'processing_time' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'currency_id' => getCurrencyId('USD'),
                'method_id' => getPaymentMethodId('Paypal'),
                'activated_for' => '{"deposit":""}',
                'method_data' => '{"client_id":"","client_secret":"","mode":"sandbox"}',
                'processing_time' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'currency_id' => getCurrencyId('EUR'),
                'method_id' => getPaymentMethodId('Paypal'),
                'activated_for' => '{"deposit":""}',
                'method_data' => '{"client_id":"","client_secret":"","mode":"sandbox"}',
                'processing_time' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'currency_id' => getCurrencyId('GBP'),
                'method_id' => getPaymentMethodId('Stripe'),
                'activated_for' => '{"deposit":""}',
                'method_data' => '{"secret_key":"","publishable_key":""}',
                'processing_time' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'currency_id' => getCurrencyId('GBP'),
                'method_id' => getPaymentMethodId('Paypal'),
                'activated_for' => '{"deposit":""}',
                'method_data' => '{"client_id":"","client_secret":"","mode":"sandbox"}',
                'processing_time' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'currency_id' => getCurrencyId('EUR'),
                'method_id' => getPaymentMethodId('Stripe'),
                'activated_for' => '{"deposit":""}',
                'method_data' => '{"secret_key":"","publishable_key":""}',
                'processing_time' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'currency_id' => getCurrencyId('USD'),
                'method_id' => getPaymentMethodId('Bank'),
                'activated_for' => '{"deposit":""}',
                'method_data' => '{"bank_id":1}',
                'processing_time' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'currency_id' => getCurrencyId('USD'),
                'method_id' => getPaymentMethodId('Bank'),
                'activated_for' => '{"deposit":""}',
                'method_data' => '{"bank_id":2}',
                'processing_time' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'currency_id' => getCurrencyId('USD'),
                'method_id' => getPaymentMethodId('Bank'),
                'activated_for' => '{"deposit":""}',
                'method_data' => '{"bank_id":3}',
                'processing_time' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'currency_id' => getCurrencyId('GBP'),
                'method_id' => getPaymentMethodId('Bank'),
                'activated_for' => '{"deposit":""}',
                'method_data' => '{"bank_id":4}',
                'processing_time' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'currency_id' => getCurrencyId('EUR'),
                'method_id' => getPaymentMethodId('Bank'),
                'activated_for' => '{"deposit":""}',
                'method_data' => '{"bank_id":5}',
                'processing_time' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'currency_id' => getCurrencyId('USD'),
                'method_id' => getPaymentMethodId('Flutterwave'),
                'activated_for' => '{"deposit":""}',
                'method_data' => '{"public_key":"","secret_key":"","secret_hash":""}',
                'processing_time' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
