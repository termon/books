<?php

namespace App\Traits;

trait EnumOptions
{
    static function options(): array
    {
        return collect(self::cases())->pluck('name', 'value')->toArray();
    }
}
