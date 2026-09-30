<?php

namespace Database\Seeders;

use App\Models\ServiceCommission;
use Illuminate\Database\Seeder;

class ServiceCommissionsTableSeeder extends Seeder
{
    public function run()
    {
        $services = [
            ['service_slug' => 'aeps', 'service_name' => 'AEPS (Aadhaar Enabled Payment System)'],
            ['service_slug' => 'recharge', 'service_name' => 'Recharge'],
            ['service_slug' => 'bbps', 'service_name' => 'BBPS Bill Payment'],
            ['service_slug' => 'bus_booking', 'service_name' => 'Bus Booking'],
            ['service_slug' => 'verification', 'service_name' => 'Verification Services'],
        ];

        foreach ($services as $s) {
            ServiceCommission::firstOrCreate(
                ['service_slug' => $s['service_slug']],
                array_merge($s, [
                    'commission_percent' => 0,
                    'commission_fixed' => 0,
                    'is_active' => true,
                ])
            );
        }
    }
}
