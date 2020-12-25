@extends('layouts.main')
@section('pageTitle', 'Transaction History')

@section('headerRight')
<h6>R={{$total_recharge}}&nbsp;&nbsp; T={{$total_transfer}}&nbsp;&nbsp;C={{$total_commission}}</h6>
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
@php $admin = \app\Services\Helper::isAdmin(); @endphp
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<div class="row">
    <div class="col-lg-12 mb-4">
        <!-- Simple Tables -->
        
        <form method="get">
            <div class="mb-4 row">
            	
            	<div class="col-sm-2">
                    <input name="start_date" class="datepicker form-control form-control-sm auto-align" type="text" placeholder="Start Date" aria-label="Search" value="{{request('start_date')}}" autocomplete="off">
                </div>
                <div class="col-sm-2">
                    <input name="end_date" class="datepicker form-control form-control-sm auto-align" type="text" placeholder="End Date" aria-label="Search" value="{{request('end_date')}}" autocomplete="off">
                </div>
                @if($admin)
                
                <div class="col-sm-1">
                    <input name="created_by" class="form-control form-control-sm auto-align" type="text" placeholder="C.ID" aria-label="Search" value="{{request('created_by')}}">
                </div>
                
                <div class="col-sm-1">
                    <input name="seller_id" class="form-control form-control-sm auto-align" type="text" placeholder="S.ID" aria-label="Search" value="{{request('seller_id')}}">
                </div>
                @endif
                
                <div class="col-sm-2">
                    <select id="Type" name="type" class="form-control form-control-sm auto-align">
                        <option value="">All Type</option>
                        <option value="recharge" {{request('type')=='recharge'?'selected':''}}>Recharge</option>
                        <option value="transfer" {{request('type')=='transfer'?'selected':''}}>Transfer</option>
                        <option value="commission" {{request('type')=='commission'?'selected':''}}>Commission</option>
                    </select>
                </div>
                
                <div class="col-sm-3">
                    <input name="query" class="form-control form-control-sm auto-align" type="text" placeholder="Search here" aria-label="Search" value="{{request('query')}}">
                </div>              
                
                
                 <div class="col-sm-3">
                     <button href="#" class="btn btn-sm btn-primary auto-align" type="submit"><i class="fa fa-search"></i> Search</button>
                     <a href="{{url('admin/transactions/')}}" class="btn btn-sm btn-default auto-align" >Reset</a>
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
                    <th>Description</th>
                    <th>Amount</th>     
                    <th>Method</th>                
                    <th>Status</th>
                    <th>By</th>
                    @if($admin) 
                    <th>Action</th>
                    @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $d)                   
                    <tr>
                    <td>{{ $d->id }}</td>
                    <td>{{ $d->created_at->format('Y-m-d H:i') }}</td> 
                    <td>{{ $d->user_id.'-'.$d->username }}</td> 
                    <td>{{ $d->plan_name }}</td> 
                    <td>{{ $d->amount }}</td>  
                    <td>{{ $d->p_method }}</td>                                     
                    @if($d->status=='complete')
                    <td><span class="badge badge-success">{{$d->status}}</span></td> 
                    @endif
                    @if($d->status=='pending')
                    <td><span class="badge badge-danger">{{$d->status}}</span></td> 
                    @endif
                    <td style="text-decoration: underline;cursor:pointer;" title="{{$d->createdBy->name}}">{{$d->created_by}}</td> 
                    @if($admin) 
                                    
                    <td>
                        <a style="margin:5px;" href="{{ url("/admin/transactions/edit").'/'.$d->id }}" class="btn btn-sm btn-warning">Edit</a> 
                        <a style="margin:5px;" d_id="{{$d->id}}" d_action="{{url('/admin/transactions/delete/'.$d->id)}}" href="#" class="btn btn-sm btn-danger delete-action-btn">Delete</a>
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