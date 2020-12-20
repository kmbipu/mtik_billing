@extends('layouts.main')
@section('pageTitle', 'Add Reseller')

@section('content')

<form method="post">
	<input type="hidden" name="role_id" value="{{$role->id}}">
  @csrf
  <div class="row">
      <div class="col-md-6 mb-4">
          <!-- Simple Tables -->
          <div class="card"> 
              <div class="card-header">User Info</div>           
              <div class="card-body">                  
                    <div class="form-group">
                      <label>Name</label>
                      <input value="{{request('name')}}" name="name" type="text" class="form-control" placeholder="Enter fullname" required>
                    </div>
                    <div class="form-group">
                      <label>Username</label>
                      <input value="{{request('username')}}" name="username" type="text" class="form-control" placeholder="Enter username" required>
                    </div>
                    <div class="form-group">
                      <label>Password</label>
                      <input value="{{request('password')}}" name="password" type="password" class="form-control" placeholder="Enter password" required>
                    </div>
                    <div class="form-group">
                      <label>Confirm Password</label>
                      <input value="{{request('password_confirmation')}}" name="password_confirmation" type="password" class="form-control" placeholder="Enter password" required>
                    </div>
              </div>         
              
          </div>
      </div>

      <div class="col-md-6 mb-4">
          <!-- Simple Tables -->
          <div class="card">            
          <div class="card-header">Profile Info</div>           
              <div class="card-body">                  
                    <div class="form-group">
                      <label>Phone</label>
                      <input value="{{request('phone')}}"  name="phone" type="text" class="form-control" placeholder="Enter phone no" required>
                    </div>
                    <div class="form-group">
                      <label>Address</label>
                      <input value="{{request('address')}}" name="address" type="text" class="form-control" placeholder="Enter address" required>
                    </div>
                    <div class="form-group">
                      <label>NID</label>
                      <input value="{{request('nid')}}" name="nid" type="text" class="form-control" placeholder="Enter NID number" required>
                    </div>
                    <br>
                    <div class="form-group text-center">
                      <button type="submit" class="btn btn-primary pull-right mr-3">Create</button>
                      <a href="{{url('admin/users/'.$role->slug.'s')}}" class="btn btn-default pull-right">Back</a>
                    </div>
                    
              </div>        
              
          </div>
      </div>    
  </div>
</form>

@endsection