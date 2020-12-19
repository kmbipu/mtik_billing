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
      
      <a href="{{url('/login')}}" class="btn btn-primary btn-lg">Login Here</a><br><br>
      <p><small class="text-white">For any inquiry - 01740964485</small></p>
    </header>

    <!-- Page Features -->
    <div class="row text-center">

      <div class="col-lg-3 col-md-6 mb-4">
        <div class="card">
          <img class="card-img-top" src="{{url('public/images/package.png')}}" alt="">
          <div class="card-body">
            <h4 class="card-title">1 Mbps Speed</h4>
            <a href="#" class="btn btn-info">৳ 500/month</a>
          </div>
        </div>
      </div>
      
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="card">
          <img class="card-img-top" src="{{url('public/images/package.png')}}" alt="">
          <div class="card-body">
            <h4 class="card-title">2 Mbps Speed</h4>
            <a href="#" class="btn btn-info">৳ 900/month</a>
          </div>
        </div>
      </div>
            <div class="col-lg-3 col-md-6 mb-4">
        <div class="card">
          <img class="card-img-top" src="{{url('public/images/package.png')}}" alt="">
          <div class="card-body">
            <h4 class="card-title">3 Mbps Speed</h4>
            <a href="#" class="btn btn-info">৳ 1000/month</a>
          </div>
        </div>
      </div>
            <div class="col-lg-3 col-md-6 mb-4">
        <div class="card">
          <img class="card-img-top" src="{{url('public/images/package.png')}}" alt="">
          <div class="card-body">
            <h4 class="card-title">5 Mbps Speed</h4>
            <a href="#" class="btn btn-info">৳ 1200/month</a>
          </div>
        </div>
      </div>


    </div>
    <!-- /.row -->

  </div>
@endsection