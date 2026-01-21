<?php

namespace Database\Seeders\versions\v4_3_0;

use Illuminate\Database\Seeder;

class MetasTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $values = [
            ['url' => 'token/send/tatumio/{walletCurrencyCode}/{walletId}', 'title' => 'Token Send', 'description' => 'Token Send', 'keywords' => ''],
            ['url' => 'token/send/tatumio/confirm', 'title' => 'Send Token Confirm', 'description' => 'Send Token Confirm', 'keywords' => ''],
            ['url' => 'token/send/tatumio/success', 'title' => 'Send Token Success', 'description' => 'Send Token Success', 'keywords' => ''],
            ['url' => 'token/receive/tatumio/{walletCurrencyCode}/{walletId}', 'title' => 'Token Receive', 'description' => 'Token Receive', 'keywords' => '']
        ];

        \DB::table('metas')->upsert($values, ['url'], ['title', 'description', 'keywords']);

    }
}
