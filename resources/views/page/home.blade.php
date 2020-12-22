@extends('layouts.public') 
@section('pageTitle', 'Welcome to S.Cable Network')
@section('content')
<div class="container">

	<style>
	header{
    	background-image: url({{url('public/images/home-banner.jpg')}});
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
	}	
	</style>
	
	
    <!-- Jumbotron Header -->
    <header class="jumbotron my-4 text-right">
      <h3 class="display-3 text-white">S. Cable Network</h3>
      
      <a href="{{url('/login')}}" class="btn btn-warning btn-lg">Login Here</a><br><br>
      <p><small class="text-white">For any inquiry - 01740964485</small></p>
    </header>

    <!-- Page Features -->
    <div class="row text-center">
	@foreach($plans as $plan)
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="card">
          <img class="card-img-top" src="{{url('public/images/package.png')}}" alt="">
          <div class="card-body">
            <h4 class="card-title">{{$plan->name}}</h4>
            <p>Speed - {{$plan->bandwidth->rate_down.' '.$plan->bandwidth->rate_down_unit}}</p>
            <p>For {{$plan->validity.' '.ucwords($plan->validity_unit)}}</p>
            <button class="btn btn-danger btn-block">৳  {{$plan->price}}</button>
          </div>
        </div>
      </div>
     @endforeach   

    </div>
    <hr>
    <!-- /.row -->
    <div class="row">
    	<div class="col-sm-12 text-center">
    		Developed by <a href="http://www.codexwp.com">CodexWP</a>
    	</div>
    </div>

  </div>
@endsection