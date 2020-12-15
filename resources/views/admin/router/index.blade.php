@extends('layouts.main')
@section('pageTitle', 'All Routers')

@section('headerRight')
<form class="form-inline ml-auto ng-pristine ng-valid" method="get" action="">

    <div class="md-form my-0">
        <input name="query" class="form-control form-control-sm" type="text" placeholder="Search here" aria-label="Search" value="{{request('query')}}">
    </div>
    <button href="#" class="btn btn-sm btn-primary btn-md my-0 ml-sm-2" type="submit"><i class="fa fa-search"></i></button>
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
                    <th>IP</th>
                    <th>User</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($routers as $router)                   
                    <tr>
                    <td>{{ $router->id }}</td>
                    <td>{{ $router->name }}</td> 
                    <td>{{ $router->ip }}</td> 
                    <td>{{ $router->username }}</td> 
                    <td>
                        <a href="{{ url("/admin/routers/edit").'/'.$router->id }}" class="btn btn-sm btn-warning">Edit</a> 
                        <a d_id="{{$router->id}}" d_action="{{url('/admin/routers/delete/'.$router->id)}}" href="#" class="btn btn-sm btn-danger delete-action-btn">Delete</a>
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