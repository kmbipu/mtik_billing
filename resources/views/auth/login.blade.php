@extends('layouts.auth')
@section('pageTitle','Login Area')
@section('content')


  <div class="text-center">
    <h1 class="h4 text-gray-900 mb-4"><i class="fa fa-lock text-success" aria-hidden="true"></i> LOGIN PANEL</h1>
  </div>
  <hr>
  <form class="user" method="post">
      @csrf
    <div class="form-group">
      <input name="username" type="text" class="form-control"  placeholder="Enter username">
    </div>
    <div class="form-group">
      <input name="password" type="password" class="form-control" placeholder="Password">
    </div>
    <div class="form-group">
      <div class="custom-control custom-checkbox small" style="line-height: 1.5rem;">
        <input name="remember" type="checkbox" class="custom-control-input" id="customCheck">
        <label class="custom-control-label" for="customCheck">Remember
          Me</label>
      </div>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-primary btn-block">Login</a>
    </div>

  </form>


@endsection
