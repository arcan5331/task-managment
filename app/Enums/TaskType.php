<?php

namespace App\Enums;

enum TaskType: string
{
    case onGoing = 'on_going';
    case completed = "completed";
    case overDu = 'over_du';
}
