<?php

namespace Database\Seeders\versions\v4_3_0;

use Illuminate\Database\Seeder;

class CryptoProviderSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('crypto_providers')->upsert([
            [
                'name' => 'TatumIo',
                'alias' => strtolower('TatumIo'),
                'description' => 'Tatum offers a flexible framework to build, run, and scale blockchain apps fast.',
                'logo' => NULL,
                'subscription_details' => '',
                'status' => 'Active',
            ]
        ], ['name'], ['alias', 'description', 'logo', 'subscription_details', 'status']);
        
    }
}
