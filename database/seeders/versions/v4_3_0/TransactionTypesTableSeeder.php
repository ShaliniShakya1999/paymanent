<?php

namespace Database\Seeders\versions\v4_3_0;

use Illuminate\Database\Seeder;

class TransactionTypesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('transaction_types')->upsert(
            [
                ['name' => 'Token_Sent'],
                ['name' => 'Token_Received']
            ],
            ['name'], 
            [] 
        );
    }
}
