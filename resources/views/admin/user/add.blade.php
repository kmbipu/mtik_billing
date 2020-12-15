@extends('layouts.main')
@section('pageTitle', 'Add User')

@section('content')

<form method="post">
  @csrf
  <div class="row">
      <div class="col-md-6 mb-4">
          <!-- Simple Tables -->
          <div class="card"> 
              <div class="card-header">User Info</div>           
              <div class="card-body">                  
                    <div class="form-group">
                      <label>Name</label>
                      <input name="name" type="text" class="form-control" placeholder="Enter fullname" required>
                    </div>
                    <div class="form-group">
                      <label>Username</label>
                      <input name="username" type="text" class="form-control" placeholder="Enter username" required>
                    </div>
                    <div class="form-group">
                      <label>Password</label>
                      <input name="password" type="password" class="form-control" placeholder="Enter password" required>
                    </div>
                    <div class="form-group">
                      <label>Confirm Password</label>
                      <input name="password_confirmation" type="password" class="form-control" placeholder="Enter password" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Role</label>
                        <select class="form-control"  name="role_id" required>
                        <option value="">Select Role</option>
                        @php $sel_role_id = isset($_GET['role_id'])?$_GET['role_id']:''; @endphp
                        @foreach($roles as $role)
                        <option value="{{$role->id}}" {{ $sel_role_id==$role->id?'selected':''}}>{{$role->name}}</option>
                        @endforeach
                        </select>
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
                      <input name="phone" type="text" class="form-control" placeholder="Enter phone no" required>
                    </div>
                    <div class="form-group">
                      <label>Address</label>
                      <input name="address" type="text" class="form-control" placeholder="Enter address" required>
                    </div>
                    <div class="form-group">
                      <label>NID</label>
                      <input name="nid" type="text" class="form-control" placeholder="Enter NID number" required>
                    </div>
                    <br>
                    <div class="form-group text-center">
                      <button type="submit" class="btn btn-primary pull-right mr-3">Create</button>
                      <button type="reset" class="btn btn-default pull-right">Reset</button>
                    </div>
                    
              </div>        
              
          </div>
      </div>    
  </div>
</form>

@endsection