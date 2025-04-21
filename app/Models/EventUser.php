<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventUser extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    public $table = 'users';
}
