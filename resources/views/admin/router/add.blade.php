@extends('layouts.main')
@section('pageTitle', 'Add Router')

@section('content')

<form method="post">
  @csrf
  <div class="row">
      <div class="col-md-6 mb-4">
          <!-- Simple Tables -->
          <div class="card">           
        
              <div class="card-body">                  
                    <div class="form-group">
                      <label>Name</label>
                      <input value="{{request('name')}}" name="name" type="text" class="form-control" placeholder="Enter router name" required>
                    </div>
                    <div class="form-group">
                      <label>IP Address</label>
                      <input value="{{request('ip')}}" name="ip" type="text" class="form-control" placeholder="Enter ip address" required>
                    </div>
                    <div class="form-group">
                      <label>Username</label>
                      <input value="{{request('username')}}" name="username" type="text" class="form-control" placeholder="Enter username" required>
                    </div>
                    <div class="form-group">
                      <label>Password</label>
                      <input value="{{request('password')}}" name="password" type="text" class="form-control" placeholder="Enter password" required>
                    </div>
                    <div class="form-group">
                      <label>Details</label>
                      <textarea name="details" class="form-control" placeholder="Enter Details (optional)">{{request('details')}}</textarea>
                    </div>
                    <br>
                    <div class="form-group text-center">
                      <button type="submit" class="btn btn-primary pull-right mr-3">Create</button>
                      <a href="{{url('admin/routers')}}" class="btn btn-default pull-right">Back</a>
                    </div>
                    
              </div>        
              
          </div>
      </div>    
  </div>
</form>

@endsection