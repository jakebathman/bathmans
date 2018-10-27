@extends('layouts.app')

@section('content')
<div class="container">
<div class="internet__wrapper p-4 row">
  <div class="internet__wrapper--status col-12 col-md-7 mb-5">
    <h2>Status</h2>
    @if (isset($status['isUp']))
      @if($status['isUp'])
      <div class="card text-white bg-success mb-3 w-100" style="">
        <h2 class="card-header">Internet is UP 😸  </h2>
        <div class="card-body">
          <h4 class="card-title my-3">The internet has been up for {{ $status['upFor'] }} </h4>
        </div>  
        <div class="card-footer">
            Last check: {{ $status['lastCheck'] }}
        </div>
      </div>
      @else
      <div class="card text-white bg-danger mb-3 w-100" style="">
        <h3 class="card-header">Internet is DOWN 😿 </h3>
        <div class="card-body">
          <h5 class="card-title my-3">The internet has been down for {{ $status['downFor'] }} </h5>
          <p class="card-text">Last check: {{ $status['lastCheck'] }}</p>
        </div>
      </div>
      @endif
    @else
      <div>
        Couldn't retrieve status 😿
      </div>
    @endif
  </div>

  <div class="internet__wrapper--data col-12 col-md-5">
    <h2>Data</h2>
      <pre>
        @json($data,JSON_PRETTY_PRINT)
      </pre>
  </div>
</div>
</div>
@endsection
