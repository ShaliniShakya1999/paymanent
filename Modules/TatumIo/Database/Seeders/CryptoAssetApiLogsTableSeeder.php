<?php

namespace Modules\TatumIo\Database\Seeders;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CryptoAssetApiLogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('crypto_asset_api_logs')->delete();

        DB::table('crypto_asset_api_logs')->insert([
            [
                'payment_method_id' => getPaymentMethodId('TatumIo'),
                'object_id' => getWalletId(getUserByEmail('irish@gmail.com'), getCurrencyId('LTCTEST')),
                'object_type' => 'wallet_address',
                'network' => 'LTCTEST',
                'payload' => '{"address":"myux6MNaBVnJkxz8Z89hmfKdci8cB4avrH","key":"cPHr7vwQoxoDN1e9vccjA4v6JAnoSStNDDxiFcG1EBNMpiTaf3BY","balance":0,"user_id":2,"wallet_id":12,"network":"LTCTEST"}',
                'confirmations' => 0,
                'created_at' => Carbon::now()->subDays(150),
                'updated_at' => Carbon::now()->subDays(150),
            ],
            [
                'payment_method_id' => getPaymentMethodId('TatumIo'),
                'object_id' => getWalletId(getUserByEmail('irish@gmail.com'), getCurrencyId('BTC')),
                'object_type' => 'wallet_address',
                'network' => 'BTC',
                'payload' => '{"address":"bc1qsxe3msnky67rknhc7ad39vnuldr5lchyz6q5d3","key":"L2NhHtL4D53vQEraYnmD91kUcabE5MPquEAjGk6vMgXjPUhyzULT","balance":0,"user_id":2,"wallet_id":13,"network":"BTC"}',
                'confirmations' => 0,
                'created_at' => Carbon::now()->subDays(145),
                'updated_at' => Carbon::now()->subDays(145),
            ],
            [
                'payment_method_id' => getPaymentMethodId('TatumIo'),
                'object_id' => getWalletId(getUserByEmail('kyla@gmail.com'), getCurrencyId('LTCTEST')),
                'object_type' => 'wallet_address',
                'network' => 'LTCTEST',
                'payload' => '{"address":"mwSHt9jDZ52XFXQTbhK6KXyBYc1Qmqx1Ae","key":"cN7Pe1zNoHWdUPzy6jgkULHe3TPBaWqU4yRZbZtZbA9SG6BgFvbK","balance":0,"user_id":3,"wallet_id":14,"network":"LTCTEST"}',
                'confirmations' => 0,
                'created_at' => Carbon::now()->subDays(140),
                'updated_at' => Carbon::now()->subDays(140),
            ],
            [
                'payment_method_id' => getPaymentMethodId('TatumIo'),
                'object_id' => getWalletId(getUserByEmail('kyla@gmail.com'), getCurrencyId('BTC')),
                'object_type' => 'wallet_address',
                'network' => 'BTC',
                'payload' => '{"address":"bc1qpuppr6zp0w0cwtsq05uqfqssg9jaj84t644qty","key":"KzL4warA4awr6SShtajfKwYBAkJ2VhD2KFU74WzpKnkpQQMmvbXf","balance":0,"user_id":4,"wallet_id":15,"network":"BTC"}',
                'confirmations' => 0,
                'created_at' => Carbon::now()->subDays(135),
                'updated_at' => Carbon::now()->subDays(135),
            ],
            [
                'payment_method_id' => getPaymentMethodId('TatumIo'),
                'object_id' => getTransactionReferenceId(Transaction::class, '37ED90852E4D5'),
                'object_type' => 'crypto_sent',
                'network' => 'LTCTEST',
                'payload' => '{"network":"LTCTEST","network_fee":"0.00006740","blockio_fee":"0.00000000","total_amount_to_send":"0.00200000","txid":"751ccc1e6186a3efaa263f5eccf50309aed01d9810aadaf2225c505b83bf2a71","senderAddress":"myux6MNaBVnJkxz8Z89hmfKdci8cB4avrH","receiverAddress":"mwSHt9jDZ52XFXQTbhK6KXyBYc1Qmqx1Ae"}',
                'confirmations' => 5,
                'created_at' => Carbon::now()->subDays(130),
                'updated_at' => Carbon::now()->subDays(130),
            ],
            [
                'payment_method_id' => getPaymentMethodId('TatumIo'),
                'object_id' => getTransactionReferenceId(Transaction::class, 'A95EC0159E9BF'),
                'object_type' => 'crypto_received',
                'network' => 'LTCTEST',
                'payload' => '{"network":"LTCTEST","address":"mwSHt9jDZ52XFXQTbhK6KXyBYc1Qmqx1Ae","balance_change":"0.00200000","amount_sent":"0.00000000","amount_received":"0.00200000","txid":"751ccc1e6186a3efaa263f5eccf50309aed01d9810aadaf2225c505b83bf2a71","confirmations":"1","is_green":null,"senderAddress":"myux6MNaBVnJkxz8Z89hmfKdci8cB4avrH","receiverAddress":"mwSHt9jDZ52XFXQTbhK6KXyBYc1Qmqx1Ae"}',
                'confirmations' => 5,
                'created_at' => Carbon::now()->subDays(125),
                'updated_at' => Carbon::now()->subDays(125),
            ],
            [
                'payment_method_id' => getPaymentMethodId('TatumIo'),
                'object_id' => getWalletId(getUserByEmail('irish@gmail.com'), getCurrencyId('DOGETEST')),
                'object_type' => 'wallet_address',
                'network' => 'DOGETEST',
                'payload' => '{"address":"nXZDuf8ooThZKFDAC1ExwT6nJK7jWSWPRc","key":"cfc9JSDDCfUaB5E7Mm68zHm6V3WJLomdTBmLw5jdwURFqkvFBhNA","balance":0,"user_id":2,"wallet_id":17,"network":"DOGETEST"}',
                'confirmations' => 0,
                'created_at' => Carbon::now()->subDays(120),
                'updated_at' => Carbon::now()->subDays(120),
            ],
            [
                'payment_method_id' => getPaymentMethodId('TatumIo'),
                'object_id' => getWalletId(getUserByEmail('kyla@gmail.com'), getCurrencyId('DOGETEST')),
                'object_type' => 'wallet_address',
                'network' => 'DOGETEST',
                'payload' => '{"address":"njsBLaRgk66e1yzqdvAK4SFNapuLfMZugE","key":"cmKrSbQZAm6UUCGkWPkr3n8FNfEebYL1BMCbnfxzaUM9SzHXEuRp","balance":0,"user_id":3,"wallet_id":18,"network":"DOGETEST"}',
                'confirmations' => 0,
                'created_at' => Carbon::now()->subDays(115),
                'updated_at' => Carbon::now()->subDays(115),
            ],
            [
                'payment_method_id' => getPaymentMethodId('TatumIo'),
                'object_id' => getTransactionReferenceId(Transaction::class, '0EF56684414D7'),
                'object_type' => 'crypto_received',
                'network' => 'DOGETEST',
                'payload' => '{"txId":"ee96656c6fc6e2a4586aedbb9b57875503c1cb374a66182364111a59888e70d4","receiverAddress":"njsBLaRgk66e1yzqdvAK4SFNapuLfMZugE","senderAddress":"nXZDuf8ooThZKFDAC1ExwT6nJK7jWSWPRc"}',
                'confirmations' => 7,
                'created_at' => Carbon::now()->subDays(110),
                'updated_at' => Carbon::now()->subDays(110),
            ],
            [
                'payment_method_id' => getPaymentMethodId('TatumIo'),
                'object_id' => getTransactionReferenceId(Transaction::class, 'C346154FE1948'),
                'object_type' => 'crypto_sent',
                'network' => 'DOGETEST',
                'payload' => '{"txId":"76e6ac8bbcfbde8b028db1891100fdc39f0aebf9007e3350421a9fe0a2ad5bc9","network_fee":"0.25807418","senderAddress":"njsBLaRgk66e1yzqdvAK4SFNapuLfMZugE","receiverAddress":"nXZDuf8ooThZKFDAC1ExwT6nJK7jWSWPRc"}',
                'confirmations' => 7,
                'created_at' => Carbon::now()->subDays(105),
                'updated_at' => Carbon::now()->subDays(105),
            ],
            [
                'payment_method_id' => getPaymentMethodId('TatumIo'),
                'object_id' => getTransactionReferenceId(Transaction::class, 'C346154FE1948') + 1, // crypto sent transaction has same uuid so crypto received transaction will be crypto sent + 1
                'object_type' => 'crypto_received',
                'network' => 'DOGETEST',
                'payload' => '{"txId":"76e6ac8bbcfbde8b028db1891100fdc39f0aebf9007e3350421a9fe0a2ad5bc9","senderAddress":"njsBLaRgk66e1yzqdvAK4SFNapuLfMZugE","receiverAddress":"nXZDuf8ooThZKFDAC1ExwT6nJK7jWSWPRc"}',
                'confirmations' => 7,
                'created_at' => Carbon::now()->subDays(95),
                'updated_at' => Carbon::now()->subDays(95),
            ],
            [
                'payment_method_id' => getPaymentMethodId('TatumIo'),
                'object_id' => getWalletId(getUserByEmail('irish@gmail.com'), getCurrencyId('TRXTEST')),
                'object_type' => 'wallet_address',
                'network' => 'TRXTEST',
                'payload' => '{"address":"TGsQV29rX8GjUYi1E8uq7MEAvaggJaEJVS","key":"d557095e9146e33b509c0d82ec401881ff24b7163ca1a3567db4daad7a0180eb","balance":31.57218,"user_id":2,"wallet_id":20,"network":"TRXTEST"}',
                'confirmations' => 0,
                'created_at' => Carbon::now()->subDays(90),
                'updated_at' => Carbon::now()->subDays(90),
            ],
            [
                'payment_method_id' => getPaymentMethodId('TatumIo'),
                'object_id' => getWalletId(getUserByEmail('kyla@gmail.com'), getCurrencyId('TRXTEST')),
                'object_type' => 'wallet_address',
                'network' => 'TRXTEST',
                'payload' => '{"address":"TChh4sFyYERb45e2DsWQ5PhhBzvYSdRxFu","key":"7a6f830dc2da17d770ff890eb63a5034d66541e0b24d3ab1b2db7a141d0bf41f","balance":0,"user_id":3,"wallet_id":21,"network":"TRXTEST"}',
                'confirmations' => 0,
                'created_at' => Carbon::now()->subDays(85),
                'updated_at' => Carbon::now()->subDays(85),
            ],
            [
                'payment_method_id' => getPaymentMethodId('TatumIo'),
                'object_id' => getTransactionReferenceId(Transaction::class, '295F40B9EA335'),
                'object_type' => 'token_sent',
                'network' => 'USDT',
                'payload' => '{"txId":"2458094f8eba532e68a3b543b216376bc4d2e6083a923b68b531e1fc9525b1dd","network_fee":"5.82348","senderAddress":"TGsQV29rX8GjUYi1E8uq7MEAvaggJaEJVS","receiverAddress":"TChh4sFyYERb45e2DsWQ5PhhBzvYSdRxFu","token":"USDT","network":"TRXTEST"}',
                'confirmations' => 7,
                'created_at' => Carbon::now()->subDays(80),
                'updated_at' => Carbon::now()->subDays(80),
            ],
            [
                'payment_method_id' => getPaymentMethodId('TatumIo'),
                'object_id' => getTransactionReferenceId(Transaction::class, '295F40B9EA335') + 1, // token sent transaction has same uuid so token received transaction will be token sent + 1
                'object_type' => 'token_received',
                'network' => 'USDT',
                'payload' => '{"txId":"2458094f8eba532e68a3b543b216376bc4d2e6083a923b68b531e1fc9525b1dd","senderAddress":"TGsQV29rX8GjUYi1E8uq7MEAvaggJaEJVS","receiverAddress":"TChh4sFyYERb45e2DsWQ5PhhBzvYSdRxFu","network":"TRXTEST" }',
                'confirmations' => 7,
                'created_at' => Carbon::now()->subDays(75),
                'updated_at' => Carbon::now()->subDays(75),
            ]
        ]);
    }
}
