<?php

namespace App\Enum;

enum MemberStatus: string
{
    case ACTIVE = 'active';
    case BLOCKED = 'blocked';
}
