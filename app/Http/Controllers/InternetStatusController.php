<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class InternetStatusController extends Controller
{
  public function index(){
    $withData = request()->has('full');
    $log = Storage::get('nmap.log');
    $groups = [30,60,120,1440,10080];
    $pattern = '/(?:Nmap done at (.*?) --)\h+1 IP address \((\d) hosts? (?:up|down)\)/';
    $logLines = collect(explode("\n",$log))->filter(function($value){
      return preg_match('/\# Nmap done/',$value);
    });

    $status = $this->getMostRecentStatus($logLines, $pattern);
    $results = [];
    $oldestLog = Carbon::now();
    $lastDown = null;
    $lastUp = null;

    foreach($groups as $g){
      $r = [
        'num' => 0,
        'up' => 0,
        'down' => 0,
        'uptimePct' => null,
        'data' => [],
      ];
      $lines = $logLines->take(-1 * $g);
      foreach($lines as $line){
        if(preg_match($pattern,$line,$parts)){
          $ts = Carbon::parse($parts[1]);
          if($ts->lt($oldestLog)){
            $oldestLog=$ts;
          }

          $r['num']+=1;
          if($parts[2]==1){
            $r['up']+=1;
            $lastUp = $ts;
          }
          else{
            $r['down']+=1;
            $lastDown = $ts;
          }
          if($withData){
            $r['data'][$parts[1]] = $parts[2];
          }
        }
      }
      $r['uptimePct'] = round(($r['up'] / $r['num'])*100,2);
      $results[$g] = $r;
    }

      $status['upFor'] = $oldestLog->diffForHumans(null,true);
      $status['downFor'] = $oldestLog->diffForHumans(null,true);

    if($lastDown){
      $status['upFor'] = $lastDown->diffForHumans(null,true);
    }
    if($lastUp){
      $status['downFor'] = $lastUp->diffForHumans(null,true);
    }

    return view('internet',[
      'data'=>$results,
      'status'=>$status,
    ]); 
  }

  public function getMostRecentStatus($log,$pattern){
    if(!preg_match($pattern,$log->take(-1),$parts)){
      return null;
    }

    return [
      'isUp'=>(bool)$parts[2],
      'lastCheck'=>Carbon::parse($parts[1])->diffForHumans(), 
      'upFor'=>Carbon::parse($parts[1])->diffForHumans(null,true),
      'downFor'=>null,
    ];
  }
}
