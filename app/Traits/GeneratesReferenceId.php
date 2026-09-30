<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait GeneratesReferenceId
{
    public static function generateReferenceId(string $prefix): string
    {
        $prefix = strtoupper($prefix);
        return $prefix . strtoupper(Str::random(8)) . time();
    }
}
