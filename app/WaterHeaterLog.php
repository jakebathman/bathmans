<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WaterHeaterLog extends Model
{
    protected $fillable = [
        'is_on',
        'noticed_when_using',
        'notes',
        'logged_at',
    ];

    protected $casts = [
        'is_on' => 'boolean',
        'noticed_when_using' => 'boolean',
    ];
}
