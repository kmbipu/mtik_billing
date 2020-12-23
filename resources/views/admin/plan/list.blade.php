@extends('layouts.main')
@section('pageTitle', 'All Plans')

@section('headerRight')
@php $admin = \app\Services\Helper::isAdmin(); @endphp
<form class="form-inline" method="get" action="">
	@if($admin)
	<div class="md-form auto-align">
        <select id="User Type" name="seller_id" class="form-control form-control-sm">
            <option value="">Select Seller</option>
            @foreach($sellers as $r) 
            	<option value="{{$r->id}}" {{request('seller_id')==$r->id?'selected':''}}>{{$r->name}}</option>
            @endforeach
        </select>
    </div>
    @endif
    <div class="md-form auto-align">
        <input name="query" class="form-control form-control-sm" type="text" placeholder="Search name" aria-label="Search" value="{{request('query')}}">
    </div>
    <button href="#" class="btn btn-sm btn-primary auto-align" type="submit"><i class="fa fa-search"></i></button>
    <a class="btn btn-sm btn-primary auto-align" href="{{url('admin/plans/add')}}"><i class="fas fa-plus"></i> Add New</a>
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
                    <th>Bandwidth</th>
                    <th>Price</th>
                    <th>Discount</th>
                    @if($admin)
                    <th>Seller</th>
                    <th>Display</th>
                    <th>Action</th>
                    @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $d)                   
                    <tr>
                    <td>{{ $d->id }}</td>
                    <td style="color:{{$d->is_active?'':'red'}}">{{ $d->name }}</td> 
                    <td>{{ $d->bandwidth->name }}</td>
                    <td>{{ $d->price }}</td>
                    <td>{{ $d->discount }}</td>
                    @if($admin)
                    <td>{{ $d->seller_id }}</td> 
                    <td>{{ $d->is_display }}</td> 
                    <td>
                        <a href="{{ url("/admin/plans/edit").'/'.$d->id }}" class="btn btn-sm btn-warning">Edit</a> 
                        <a d_id="{{$d->id}}" d_action="{{url('/admin/plans/delete/'.$d->id)}}" href="#" class="btn btn-sm btn-danger delete-action-btn">Delete</a>
                    </td>
                    @endif
                    </tr>
                    @endforeach
                </tbody>
                </table>
            </div>           
            <div class="card-footer">{{ $data->appends(request()->all())->links('paginator') }}</div>

        </div>
    </div>
</div>

@endsection