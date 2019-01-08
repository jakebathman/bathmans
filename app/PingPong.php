<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PingPong extends Model
{
    protected $table = 'ping_pongs';

    protected $guarded = [];

    public $timestamps = false;
}
