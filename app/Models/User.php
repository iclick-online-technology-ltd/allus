<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    public $table = 'users';

    protected $casts = [
        'interests' => 'array',
    ];

    protected $fillable = [
        'status',
    ];
}
