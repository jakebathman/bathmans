<?php

namespace App\Http\Controllers;

use App\WaterHeaterLog;
use Illuminate\Http\Request;

class WaterHeaterLogController extends Controller
{
    public function index()
    {
        return WaterHeaterLog::orderBy('logged_at')->get();
    }

    public function store(Request $request)
    {
        try {
            $log = WaterHeaterLog::create(request()->all());
            $log->save();

            return [
                'status' => 'success',
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
