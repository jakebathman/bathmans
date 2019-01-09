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

            $dataInternal = self::where('created_at', '>=', $earliest)->internal()->get();
            $dataExternal = self::where('created_at', '>=', $earliest)->external()->get();

            $successInternal = $dataInternal->where('is_successful', 1)->count();
            $successExternal = $dataExternal->where('is_successful', 1)->count();

            $countInternal = $dataInternal->count();
            $countExternal = $dataExternal->count();

            $uptimeInternal = $countInternal == 0 ? 0 : 100 * ($successInternal / $countInternal);
            $uptimeExternal = $countExternal == 0 ? 0 : 100 * ($successExternal / $countExternal);

            $summary[] = [
                'group' => $group,
                'earliest_item' => $earliest,
                'count' => $countInternal + $countExternal,
                'count_internal' => $countInternal,
                'count_external' => $countExternal,
                'uptime_internal' => $uptimeInternal,
                'uptime_external' => $uptimeExternal,
                'uptime' => ($uptimeInternal + $uptimeExternal) / 2,
            ];
        }

        return $summary;
    }
}
