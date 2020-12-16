@extends('layouts.main')
@section('pageTitle', 'All Plans')

@section('headerRight')
<form class="form-inline ml-auto ng-pristine ng-valid" method="get" action="">

    <div class="md-form my-0">
        <input name="query" class="form-control form-control-sm" type="text" placeholder="Search here" aria-label="Search" value="{{request('query')}}">
    </div>
    <button href="#" class="btn btn-sm btn-primary btn-md my-0 ml-sm-2" type="submit"><i class="fa fa-search"></i></button>
    <a class="btn btn-sm btn-primary btn-md my-0 ml-sm-2" href="{{url('admin/plans/add')}}"><i class="fas fa-plus"></i> Add New</a>
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
                    <th>Router</th>
                    <th>Bandwidth</th>
                    <th>Price</th>
                    <th>Validity</th>
                    <th>Reseller</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $d)                   
                    <tr>
                    <td>{{ $d->id }}</td>
                    <td>{{ $d->name }}</td> 
                    <td>{{ $d->router->name }}</td> 
                    <td>{{ $d->bandwidth->name }}</td>
                    <td>{{ $d->price }}</td>
                    <td>{{ $d->validity.' '.$d->validity_unit }}</td>
                    <td>{{ $d->reseller_id }}</td> 
                    <td>
                        <a href="{{ url("/admin/plans/edit").'/'.$d->id }}" class="btn btn-sm btn-warning">Edit</a> 
                        <a d_id="{{$d->id}}" d_action="{{url('/admin/plans/delete/'.$d->id)}}" href="#" class="btn btn-sm btn-danger delete-action-btn">Delete</a>
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