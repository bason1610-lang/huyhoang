<?php

namespace App\Helpers;

class Price
{
    public static function format(int|float $amount): string
    {
        return number_format((float) $amount, 0, ',', '.').'₫';
    }
}
