<?php

namespace App\Http\Controllers;

use App\PingPong;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Pong extends Controller
{
    public function __invoke(Request $request)
    {
        $pong = PingPong::create([
            'created_at' => Carbon::now('UTC'),
            'source' => 'internal',
            'is_successful' => 1,
        ]);

        return $pong;
    }
}
