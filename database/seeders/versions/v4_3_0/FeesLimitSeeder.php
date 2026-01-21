<?php

namespace Database\Seeders\versions\v4_3_0;

use Illuminate\Database\Seeder;

class FeesLimitSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('fees_limits')->upsert(
            [
                [
                    'currency_id'         => 1,
                    'transaction_type_id' => 1,
                    'payment_method_id'   => 9,
                    'charge_percentage'   => 0.00000000,
                    'charge_fixed'        => 0.00000000,
                    'min_limit'           => 1.00000000,
                    'max_limit'           => null,
                    'has_transaction'     => 'Yes',
                ]
            ], 
            ['currency_id', 'transaction_type_id', 'payment_method_id'], // Unique columns
            ['charge_percentage', 'charge_fixed', 'min_limit', 'max_limit', 'has_transaction'] // Columns to update
        );
    }
}
