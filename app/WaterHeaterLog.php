<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WaterHeaterLog extends Model
{
    protected $fillable = [
        'is_on',
        'notes',
        'logged_at',
    ];
}
