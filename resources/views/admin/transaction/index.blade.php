@extends('layouts.main')
@section('pageTitle', 'All Transactions')

@section('headerRight')
<form class="form-inline ml-auto ng-pristine ng-valid" method="get" action="">
	<div class="md-form my-0 mr-2">
        <select name="created_by" class="form-control form-control-sm">
            <option value="">Show All</option>
            <option value="{{Auth::user()->id}}">My Trans.</option>
            @foreach($resellers as $r) 
            	<option value="{{$r->id}}" {{request('created_by')==$r->id?'selected':''}}>{{$r->name}}</option>
            @endforeach
        </select>
    </div>
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
                    <th>User</th>
                    <th>Plan</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $d)                   
                    <tr>
                    <td>{{ $d->id }}</td>
                    <td>{{ $d->username }}</td> 
                    <td>{{ $d->plan_name }}</td> 
                    <td>{{ $d->amount }}</td>
                    <td>{{ $d->created_at->format('Y-m-d') }}</td>                   
                    @if($d->status=='complete')
                    <td><span class="badge badge-success">{{$d->status}}</span></td> 
                    @endif
                    @if($d->status=='pending')
                    <td><span class="badge badge-danger">{{$d->status}}</span></td> 
                    @endif                    
                    <td>
                        <a href="{{ url("/admin/transactions/edit").'/'.$d->id }}" class="btn btn-sm btn-warning">Edit</a> 
                        <a d_id="{{$d->id}}" d_action="{{url('/admin/transactions/delete/'.$d->id)}}" href="#" class="btn btn-sm btn-danger delete-action-btn">Delete</a>
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