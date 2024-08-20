<?php

namespace App\Enums;

enum TaskSuperiority: string
{
    case critical = "critical";
    case normal = "normal";
    case insignificant = "insignificant";
}
