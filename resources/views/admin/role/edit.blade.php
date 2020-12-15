@extends('layouts.main')
@section('pageTitle', 'Edit Role : '.$role->id)

@section('headerRight')
<a class="btn btn-sm btn-primary btn-md my-0 ml-sm-2" href="{{url('admin/roles')}}"><i class="fas fa-bars"></i> List</a>
@endsection

@section('content')

<div class="row">
    <div class="col-md-6 mb-4">
        <!-- Simple Tables -->
        <div class="card">            
            <div class="card-body">
                  <form method="post">
                  @csrf
                  <div class="form-group">
                      <label for="exampleFormControlSelect1">Group</label>
                      <select class="form-control" id="" name="type">
                        <option value="admin" {{ $role->type=='admin'?'selected':''}}>Admin</option>
                        <option value="reseller" {{ $role->type=='reseller'?'selected':''}}>Reseller</option>
                        <option value="customer" {{ $role->type=='customer'?'selected':''}}>Customer</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="input_role_name">Role Name</label>
                      <input name="name" type="text" class="form-control" id="input_role_name" aria-describedby="emailHelp" placeholder="Enter a role name" value="{{ $role->name }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button> <a href="{{ url("/admin/roles") }}" class="btn btn-default">Back</a>
                    <a href="{{url('admin/roles')}}" class="btn btn-default pull-right">Back</a>

                  </form>
            </div>         
            
        </div>
    </div>
</div>

@endsection