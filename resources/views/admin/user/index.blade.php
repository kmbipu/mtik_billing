@extends('layouts.main')
@section('pageTitle', 'All Users')

@section('headerRight')
<form class="form-inline ml-auto ng-pristine ng-valid" method="get" action="">
    <div class="md-form my-0 mr-2">
        <select id="User Type" name="role_id" class="form-control form-control-sm">
            <option value="">Select Role</option>
            @php $sel_role_id = isset($_GET['role_id'])?$_GET['role_id']:''; @endphp
            @foreach($roles as $role)
            <option value="{{$role->id}}" {{ $sel_role_id==$role->id?'selected':''}}>{{$role->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="md-form my-0">
        <input name="query" class="form-control form-control-sm" type="text" placeholder="Search here" aria-label="Search" value="{{request('query')}}">
    </div>
    <button href="#" class="btn btn-sm btn-primary btn-md my-0 ml-sm-2" type="submit"><i class="fa fa-search"></i></button>
    <a class="btn btn-sm btn-primary btn-md my-0 ml-sm-2" href="{{url('admin/users/add')}}"><i class="fas fa-plus"></i> Add New</a>

</form>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 mb-4">
        <!-- Simple Tables -->
        <div class="card">            
            <div class="table-responsive">
                <table class="table align-items-center table-flush table-td-sm">
                <thead class="thead-light">
                    <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>User</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)                   
                    <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td> 
                    <td>{{ $user->username }}</td> 
                    <td>{{ $user->phone }}</td> 
                    <td>{{ $user->role->name }}</td>                     
                    <td>{{ $user->active_status?'active':'inactive' }}</td> 
                    <td>
                        <a href="{{ url("/admin/users/edit").'/'.$user->id }}" class="btn btn-sm btn-warning">Edit</a> 
                        <a d_id="{{$user->id}}" d_action="{{url('/admin/users/delete/'.$user->id)}}" href="#" class="btn btn-sm btn-danger delete-action-btn">Delete</a>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
            </div>           
            <div class="card-footer"></div>
        </div>
    </div>
</div>

@endsection