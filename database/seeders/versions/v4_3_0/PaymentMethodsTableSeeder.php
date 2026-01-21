<?php

namespace Database\Seeders\versions\v4_3_0;

use Illuminate\Database\Seeder;

class PaymentMethodsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('payment_methods')->upsert(
            [
                ['name' => 'TatumIo', 'status' => 'Active'],
                ['name' => 'Coinbase', 'status' => 'Active']
            ],
            ['name'], 
            ['status'] 
        );
    }
}
