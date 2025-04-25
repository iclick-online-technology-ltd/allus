<?php

namespace App\Enum;

enum EventStatus: string
{
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}
