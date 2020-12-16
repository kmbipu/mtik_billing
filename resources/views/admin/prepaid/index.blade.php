@extends('layouts.main')
@section('pageTitle', 'All Prepaid Users')

@section('headerRight')
<form class="form-inline ml-auto ng-pristine ng-valid" method="get" action="">

    <div class="md-form my-0">
        <input name="query" class="form-control form-control-sm" type="text" placeholder="Search here" aria-label="Search" value="{{request('query')}}">
    </div>
    <button href="#" class="btn btn-sm btn-primary btn-md my-0 ml-sm-2" type="submit"><i class="fa fa-search"></i></button>
    <a class="btn btn-sm btn-primary btn-md my-0 ml-sm-2" href="{{url('admin/prepaids/recharge')}}"><i class="fas fa-plus"></i> Recharge</a>
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
                    <th>Reseller</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $d)                   
                    <tr>
                    <td style="color:{{$d->status?'green':'red'}}">{{ $d->user->username }}</td> 
                    <td>{{ $d->plan->name }}</td>
                    <td>{{ $d->start_dt }}</td>
                    <td>{{ $d->expire_dt }}</td>
                    <td>{{ $d->reseller_id }}</td>                    
                    <td>
                        <a href="{{ url("/admin/prepaids/edit").'/'.$d->id }}" class="btn btn-sm btn-warning">Edit</a> 
                         <a href="{{ url("/admin/prepaids/renew").'/'.$d->id }}" class="btn btn-sm btn-info">Renew</a>
                        <a d_id="{{$d->id}}" d_action="{{url('/admin/prepaids/delete/'.$d->id)}}" href="#" class="btn btn-sm btn-danger delete-action-btn">Delete</a>
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