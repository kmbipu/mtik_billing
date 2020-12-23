@extends('layouts.main')
@section('pageTitle', 'All PPPoe Users')

@section('headerRight')
@php
$admin = \app\Services\Helper::isAdmin();
@endphp
<form class="form-inline" method="get" action="">
	@if($admin)
	<div class="md-form my-0 mr-2">
        <select id="User Type" name="created_by" class="form-control form-control-sm">
            <option value="">Select Seller</option>
            @foreach($sellers as $r) 
            	<option value="{{$r->id}}" {{request('created_by')==$r->id?'selected':''}}>{{$r->name}}</option>
            @endforeach
        </select>
    </div>
    @endif
    <div class="md-form auto-align">
        <select id="User Type" name="plan_id" class="form-control form-control-sm">
            <option value="">All Plans</option>
            @foreach($plans as $p) 
            	<option value="{{$p->id}}" {{request('plan_id')==$p->id?'selected':''}}>{{$p->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="md-form auto-align">
        <input  name="query" class="form-control form-control-sm" type="text" placeholder="Search name, user, id" aria-label="Search" value="{{request('query')}}">
    </div>
    <button href="#" class="btn btn-sm btn-primary auto-align" type="submit"><i class="fa fa-search"></i></button>
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
                    <th>User</th>
                    <th>Plan</th>    
                    <th>Start</th>   
                    <th>Expire</th>
                    <th>Seller</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $d)                   
                    <tr>
                    <td style="color:{{$d->status?'green':'red'}}">{{$d->username }}</td> 
                    <td>{{ \app\Services\PlanService::find($d->plan_id)->name }}</td>   
                    <td>{{ $d->start_dt }}</td>                
                    <td style="color:{{date('Y-m-d') > $d->expire_dt?'red':''}}">{{ $d->expire_dt }}</td>
                    <td>{{ $d->created_by }}</td>                    
                    <td>
                    	<a href="{{ url("/admin/prepaids/renew").'/'.$d->id }}" class="btn btn-sm btn-info">Renew</a>
                    	
                    	@if($admin)
                         <a href="{{ url("/admin/prepaids/edit").'/'.$d->id }}" class="btn btn-sm btn-warning">Edit</a>
                         <a d_id="{{$d->id}}" d_action="{{url('/admin/prepaids/delete/'.$d->id)}}" href="#" class="btn btn-sm btn-danger delete-action-btn">Delete</a>
                    	@endif
                    </td>
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