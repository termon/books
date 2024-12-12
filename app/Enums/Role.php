<?php

namespace App\Enums;

use App\Traits\EnumOptions;

enum Role: string
{
    use EnumOptions;

    case ADMIN = "admin";
    case AUTHOR = "author";
    case GUEST = "guest";
}
