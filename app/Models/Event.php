<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'status',
    ];

    public $timestamps = false;

    protected $casts = [
        'filters' => 'array',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'host_id');
    }
}
