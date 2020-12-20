@extends('layouts.main')
@section('pageTitle', 'Recharge History')

@section('headerRight')
<h5>Total - {{$total}}</h5>
@endsection

@section('bottomScripts')
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( ".datepicker" ).datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: 'yy-mm-dd'
    });
  } );
  </script>
@endsection

@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<div class="row">
    <div class="col-lg-12 mb-4">
        <!-- Simple Tables -->
        
        <form method="get">
            <div class="mb-4 row">
            	
            	<div class="col-sm-2">
                    <input name="start_date" class="datepicker form-control form-control-sm" type="text" placeholder="Start Date" aria-label="Search" value="{{request('start_date')}}" autocomplete="off">
                </div>
                <div class="col-sm-2">
                    <input name="end_date" class="datepicker form-control form-control-sm" type="text" placeholder="End Date" aria-label="Search" value="{{request('end_date')}}" autocomplete="off">
                </div>
                
                <div class="col-sm-2">
                    <input name="created_by" class="form-control form-control-sm" type="text" placeholder="Admin/Reseller ID" aria-label="Search" value="{{request('created_by')}}">
                </div>
                <div class="col-sm-3">
                    <input name="query" class="form-control form-control-sm" type="text" placeholder="ID,User,Method.." aria-label="Search" value="{{request('query_str')}}">
                </div>
                 <div class="col-sm-3">
                     <button href="#" class="btn btn-sm btn-info btn-md my-0 ml-sm-2" type="submit"><i class="fa fa-search"></i> Search</button>
                     <a href="{{url('admin/transactions/recharges')}}" class="btn btn-sm btn-default btn-md my-0 ml-sm-2" >Reset</a>
                 </div>  
          
            </div>
        </form>
        <div class="card">            
            <div class="table-responsive">
                <table class="table align-items-center table-flush table-td-sm">
                <thead class="thead-light">
                    <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>User</th>
                    <th>Plan</th>
                    <th>Amount</th>     
                    <th>Method</th>                
                    <th>Status</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $d)                   
                    <tr>
                    <td>{{ $d->id }}</td>
                    <td>{{ $d->created_at->format('Y-m-d') }}</td> 
                    <td>{{ $d->username }}</td> 
                    <td>{{ $d->plan_name }}</td> 
                    <td>{{ $d->amount }}</td>  
                    <td>{{ $d->p_method }}</td>                                     
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