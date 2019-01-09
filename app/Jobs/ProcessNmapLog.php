<?php

namespace App\Jobs;

use App\PingPong;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\PingPongSummary;

class ProcessNmapLog implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $log = Storage::get('nmap.log');
        $groups = [30,60,120,1440,10080];
        $pattern = '/(?:Nmap done at (.*?) --)\h+1 IP address \((\d) hosts? (?:up|down)\)/';
        $logLines = collect(explode("\n", $log))->filter(function ($value) {
            return preg_match('/\# Nmap done/', $value);
        });

        $status = $this->getMostRecentStatus($logLines, $pattern);
        $results = [];
        $oldestLog = Carbon::now();
        $lastDown = null;
        $lastUp = null;

        foreach ($groups as $g) {
            $r = [
                'num' => 0,
                'up' => 0,
                'down' => 0,
                'uptimePct' => null,
                'data' => [],
            ];
            $lines = $logLines->take(-1 * $g);
            foreach ($lines as $line) {
                if (preg_match($pattern, $line, $parts)) {
                    $ts = Carbon::parse($parts[1]);
                    if ($ts->lt($oldestLog)) {
                        $oldestLog = $ts;
                    }

                    $r['num'] += 1;
                    if ($parts[2] == 1) {
                        $r['up'] += 1;
                        $lastUp = $ts;
                    } else {
                        $r['down'] += 1;
                        $lastDown = $ts;
                    }

                    // Log to the database
                    $p = PingPong::firstOrNew([
                        'created_at' => $ts,
                    ]);
                    $p->source = 'external';
                    $p->is_successful = $parts[2];
                    $p->save();
                }
            }
            $r['uptimePct'] = round(($r['up'] / $r['num']) * 100, 2);
            $results[$g] = $r;
        }

        // Store summary groups in ping_pong_summaries
        $summaries = PingPong::getSummary();
        foreach ($summaries as $summary) {
            $s = PingPongSummary::firstOrCreate(['group' => $summary['group']]);
            $s->update($summary);
            $s->save();
        }
        dump($results);
    }

    public function getMostRecentStatus($log, $pattern)
    {
        if (!preg_match($pattern, $log->take(-1), $parts)) {
            return null;
        }

        return [
            'isUp' => (bool)$parts[2],
            'lastCheck' => Carbon::parse($parts[1])->diffForHumans(),
            'upFor' => Carbon::parse($parts[1])->diffForHumans(null, true),
            'downFor' => null,
        ];
    }
}
