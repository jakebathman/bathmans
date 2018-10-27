@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      @if (session('status'))
        <div class="alert alert-success" role="alert">
          {{ session('status') }}
        </div>
      @endif

      @guest
      <div class="text-center pt-10">
        <h1>
          😸          
        </h1>
      </div>
      @endguest


      @auth
      
      <a href="internet" class="btn btn-primary btn-block btn-lg">Internet status</a>


      @endauth
    </div>
  </div>
</div>
@endsection
