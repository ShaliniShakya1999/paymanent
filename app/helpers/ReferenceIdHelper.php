<?php

namespace App\Helpers;

class ReferenceIdHelper
{
    public static function generate(string $prefix): string
    {
        return strtoupper($prefix) . time() . rand(1000, 9999);
    }

    public static function forAeps(): string
    {
        return self::generate('AEPS');
    }

    public static function forBusBooking(): string
    {
        return self::generate('BUS');
    }
}
