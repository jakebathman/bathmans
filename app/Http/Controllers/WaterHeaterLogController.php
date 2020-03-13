<?php

namespace App\Http\Controllers;

use App\WaterHeaterLog;
use Illuminate\Http\Request;

class WaterHeaterLogController extends Controller
{
    public function index()
    {
        return [
            'status' => 'success',
            'streak' => $this->getCurrentStreak(),
            'data' => WaterHeaterLog::orderBy('logged_at', 'DESC')->get(),
        ];
    }

    public function store(Request $request)
    {
        try {
            $log = WaterHeaterLog::create([
                'is_on' => (int)request('is_on'),
                'logged_at' => request('logged_at'),
                'notes' => request('notes'),
            ]);
            $log->save();

            $log = $log->fresh();

            return [
                'status' => 'success',
                'streak' => $this->getCurrentStreak(),
                'data' => $log->fresh(),
            ];
        } catch (\Throwable $th) {
            return [
                'status' => 'error',
                'code' => $th->getCode(),
                'message' => $th->getMessage(),
            ];
        }
    }

    public function getCurrentStreak()
    {
        $logs = WaterHeaterLog::orderBy('logged_at', 'DESC')->get();

        $continue = true;
        return $logs->filter(function ($log) use (&$continue) {
            if (! $continue) {
                // Reject this log, we've reached the last usable one already
                return false;
            }

            if (! $log->is_on) {
                $continue = false;
                return false;
            }

            return true;
        })
        ->count();
    }

    public function show(WaterHeaterLog $waterHeaterLog)
    {
        //
    }

    public function edit(WaterHeaterLog $waterHeaterLog)
    {
        //
    }

    public function update(Request $request, WaterHeaterLog $waterHeaterLog)
    {
        //
    }

    public function destroy(WaterHeaterLog $waterHeaterLog)
    {
        //
    }
}
