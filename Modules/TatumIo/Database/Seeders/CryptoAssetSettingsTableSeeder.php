<?php

namespace Modules\TatumIo\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CryptoAssetSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('crypto_asset_settings')->delete();

        DB::table('crypto_asset_settings')->insert([
            [
                'currency_id' => getCurrencyId('LTCTEST'),
                'crypto_provider_id' => getCryptoProviderId('tatumio'),
                'payment_method_id' => getPaymentMethodId('TatumIo'),
                'network' => 'LTCTEST',
                'network_credentials' => '{"api_key":"t-64f72e1e0c34f3d88debad28-472d122e6447428ba4cb8d5e","coin":"Litecoin","mnemonic":"gap slush dish parade kite thumb neglect blush laptop public essence rescue audit soul fire veteran loud axis debris elite sadness blood film produce","xpub":"ttub4fGyLGjHAdT5aRnqUAknhkszEXvNuDJdNb61cRhV3v9ER1XQUAQYc2z4dvP954aSDw4F2mQAvfTUjfTeM19PkJTEbgGdvnZUBjrJcc93QFq","key":"cPMt7igNqJzSr7oFPsM3CquGfmaPJxidmzxJ9RrKWSXR3aqCNVoN","address":"mmxYC261zVX6zP3BUeBCsbVjrwrbBYDksR","balance":0}',
                'status' => 'Active',
                'created_at' => Carbon::now()->subDays(65),
                'updated_at' => Carbon::now()->subDays(65),
            ],
            [
                'currency_id' => getCurrencyId('BTC'),
                'crypto_provider_id' => getCryptoProviderId('tatumio'),
                'payment_method_id' => getPaymentMethodId('TatumIo'),
                'network' => 'BTC',
                'network_credentials' => '{"api_key":"t-64e1f8e6e4c882001c8d633d-64e1f8e6e4c882001c8d633e","coin":"Bitcoin","mnemonic":"rabbit elder game immune reason actual nerve surface valve spray high fever march observe cup sphere impulse kingdom kangaroo fall swarm powder script cactus","xpub":"xpub6F3UaMWM66qLW3spExgtMecXRKjHC7a2qmLGzjg7Hu8gCyxiX5xJM7V5XPeSB9jbCVQxgrRt6ogsuSpobzwSoPHpuTEcHd1oBUtzLqSci5v","key":"KyY8Qz6KBBZ8GaVtzswP5sn2LzzcVqj6xbgtTgeaCKT1WsqpL4gq","address":"bc1qqfe6v2fr3yctegsj3mys4nalqppgfe8n7smmkf","balance":0}',
                'status' => 'Active',
                'created_at' => Carbon::now()->subDays(60),
                'updated_at' => Carbon::now()->subDays(60),
            ],
            [
                'currency_id' => getCurrencyId('DOGETEST'),
                'crypto_provider_id' => getCryptoProviderId('tatumio'),
                'payment_method_id' => getPaymentMethodId('TatumIo'),
                'network' => 'DOGETEST',
                'network_credentials' => '{"api_key":"t-64e1f8e6e4c882001c8d633d-64e1f8e7466065001cc7152e","coin":"Dogecoin","mnemonic":"prevent doll gossip melody coin bar cup egg kingdom lumber another beyond victory orange reunion canal place develop ice final fragile dawn system security","xpub":"tpubDDwkwJ9kPjt9g2V4VWPkGvTEG5WgN2jVuZKKGN4uJ3rFqCYiFvzhZ2a8DHbyDPR4XfUz1AaPt9Ja4Rk36jx1cm3Qzrj5gPNHzXHo23zbH2t","key":"ciHnpwdrwZUEXS61yAqunbrfxJV7vH2WrCpwJk9Bdz74M1z82T5H","address":"ndWBXBpiaov2dFqNmnfhX4LtfGF7xJHBju","balance":90}',
                'status' => 'Active',
                'created_at' => Carbon::now()->subDays(55),
                'updated_at' => Carbon::now()->subDays(55),
            ],
            [
                'currency_id' => getCurrencyId('TRXTEST'),
                'crypto_provider_id' => getCryptoProviderId('tatumio'),
                'payment_method_id' => getPaymentMethodId('TatumIo'),
                'network' => 'TRXTEST',
                'network_credentials' => '{"api_key":"t-64e1f8e6e4c882001c8d633d-64e1f8e7466065001cc7152e","coin":"Tron","mnemonic":"skin wrong antenna shrug faint twelve outdoor crumble cereal toss planet police cart fan attack spy color shrimp session enable height half general weasel","xpub":"xpub6EEkTPW7xwVs6J1cfJjS3AmPzzEJiewDTmDjJKTToS92y1PK758BPBQmrssWojrEwwS8JBeenhfW9jFzeJpTm3TXiwFtuTebMbWbP9NRDtj","key":"8654b9d8ccb3e9c37f5bd1fba46e0e8881ef9d4eb606782bdd550936c30d34fc","address":"TCY9YJiN5MwFsfuoHpNhA1Fu6SKNSDBvHR","balance":1927.12152}',
                'status' => 'Active',
                'created_at' => Carbon::now()->subDays(50),
                'updated_at' => Carbon::now()->subDays(50),
            ]
        ]);
    }
}
