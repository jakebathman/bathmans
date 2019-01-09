<?php

namespace App;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PingPong extends Model
{
    protected $table = 'ping_pongs';

    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function scopeSuccessful($query)
    {
        return $query->where('is_successful', 1);
    }

    public function scopeInternal($query)
    {
        return $query->where('source', 'internal');
    }

    public function scopeExternal($query)
    {
        return $query->where('source', 'external');
    }


    public static function getSummary($minutesBack = null)
    {
        $groups = [30,60,120,1440,10080];

        if ($minutesBack) {
            $groups = [$minutesBack];
        }

        $summary = [];
        foreach ($groups as $group) {
            $earliest = Carbon::now('UTC')->subMinutes($group)->format('Y-m-d H:i:s');

            $data = self::where('created_at', '>=', $earliest)->get();

            $successInternal = self::internal()->successful()->count();
            $successExternal = self::external()->successful()->count();

            $countInternal = self::internal()->successful()->count();
            $countExternal = self::external()->successful()->count();

            $summary[] = [
                'group' => $group,
                'earliest_item' => $earliest,
                'count' => $data->count(),
                'uptime_internal' => 100 * ($successInternal / $countInternal),
                'uptime_external' => 100 * ($successExternal / $countExternal),
                'uptime' => 100 * ((($successInternal / $countInternal) + ($successExternal / $countExternal)) / 2),
            ];
        }

        return $summary;
    }
}
