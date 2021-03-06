<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PingPongSummary extends Model
{
    protected $table = 'ping_pong_summaries';

    protected $guarded = [];

    protected $casts = [
        'earliest_item' => 'datetime:Y-m-d H:i:s',
    ];
}
