<?php

namespace App\Enum;

enum UserGender: string
{
    case MALE = 'male';
    case FEMALE = 'female';
    case NON_BINARY = 'non-binary';
}
