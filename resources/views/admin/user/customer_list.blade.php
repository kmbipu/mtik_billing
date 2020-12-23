@extends('layouts.main')
@section('pageTitle', 'All Customers')

@section('headerRight')

@php $admin = \app\Services\Helper::isAdmin(); @endphp

<form class="form-inline " method="get" action="">
	@if($admin)
	<div class="md-form auto-align">
        <input name="created_by" class="form-control form-control-sm" type="text" placeholder="Seller ID" aria-label="Search" value="{{request('created_by')}}">
    </div>
    @endif
    <div class="md-form auto-align">
        <input name="query" class="form-control form-control-sm" type="text" placeholder="Search name, user, phone" aria-label="Search" value="{{request('query')}}">
    </div>
    <button href="#" class="btn btn-sm btn-primary auto-align" type="submit"><i class="fa fa-search"></i></button>
    <a class="btn btn-sm btn-primary auto-align" href="{{url('admin/users/customers/add')}}"><i class="fas fa-plus"></i> Add New</a>

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
                    <th>Seller</th>
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
                    <td>{{ $user->created_by }}</td>                 
                    <td>
                        <a href="{{ url("/admin/users/edit").'/'.$user->id }}" class="btn btn-sm btn-warning">Edit</a> 
                        <a d_id="{{$user->id}}" d_action="{{url('/admin/users/delete/'.$user->id)}}" href="#" class="btn btn-sm btn-danger delete-action-btn">Delete</a>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
            </div>           
            <div class="card-footer">{{ $users->appends(request()->all())->links('paginator') }}</div>

        </div>
    </div>
</div>

@endsection