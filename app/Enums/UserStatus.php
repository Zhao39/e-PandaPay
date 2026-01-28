<?php

namespace App\Enums;

enum UserStatus: string
{
    case Blocked = 'blocked';
    case Active = 'active';
}
