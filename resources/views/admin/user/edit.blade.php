@extends('layouts.main')
@section('pageTitle', 'Edit User : '.$user->id)

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
                      <input name="name" type="text" class="form-control" placeholder="Enter fullname" value="{{$user->name}}" required>
                    </div>
                    <div class="form-group">
                      <label>Username</label>
                      <input type="text" class="form-control" readonly="true" value="{{$user->username}}">
                    </div>                    
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Role</label>
                        <select class="form-control"  name="role_id" required>
                        <option value="">Select Role</option>
                        @foreach($roles as $role)
                        <option value="{{$role->id}}" {{ $user->role_id==$role->id?'selected':''}}>{{$role->name}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Active Status</label>
                        <select class="form-control"  name="active_status" required>
                        <option value="">Select Status</option>
                        <option value="1" {{ $user->active_status?'selected':''}}>Active</option>
                        <option value="0" {{ !$user->active_status?'selected':''}}>Inactive</option>
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
                      <input name="phone" type="text" class="form-control" placeholder="Enter phone no" value="{{$user->phone}}" required>
                    </div>
                    <div class="form-group">
                      <label>Address</label>
                      <input name="address" type="text" class="form-control" placeholder="Enter address" value="{{$user->address}}" required>
                    </div>
                    <div class="form-group">
                      <label>NID</label>
                      <input name="nid" type="text" class="form-control" placeholder="Enter NID number" value="{{$user->nid}}" required>
                    </div>
                    <br>
                    <div class="form-group text-center">
                      <button type="submit" class="btn btn-primary pull-right mr-3">Update</button>
                      <a href="{{url('admin/users')}}" class="btn btn-default pull-right">Back</a>
                    </div>
                    
              </div>        
              
          </div>
      </div>    
  </div>
</form>

@endsection