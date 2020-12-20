@extends('layouts.main') 
@section('pageTitle', 'Edit Transaction : '.$data->id)

@section('content')

<form method="post">
	@csrf
	<div class="row">
	
		<div class="col-md-6 mb-4">
			<!-- Simple Tables -->
			<div class="card">

				<div class="card-body">					
					
					<div class="table-responsive">
                        <table class="table table-td-sm table-bordered">  
                            <tbody>
                            	<tr><td>ID</td><td>{{$data->id}}</td><tr>
                            	<tr><td>Username</td><td>{{$data->username}}</td><tr>
                            	<tr><td>Plan</td><td>{{$data->plan_name}}</td><tr>  
                            	<tr><td>Amount</td><td>{{$data->amount}}</td><tr>  
                            	<tr><td>Method</td><td>{{ucwords($data->p_method)}}</td><tr>  
                            	<tr><td>Trx ID</td><td>{{$data->p_trxid}}</td><tr>                         	
                            	<tr><td>Date</td><td>{{ $data->created_at->format('Y-m-d') }}</td><tr>
                            	<tr>
                            		<td>Status</td>
                            		<td>
                            		<select class="form-control" name="status" required>
            							<option value="pending" {{$data->status=='pending'?'selected':''}}>Pending</option>
            							<option value="complete" {{$data->status=='complete'?'selected':''}}>Complete</option>
            						</select>
                            		</td>
								<tr>
                            </tbody>
                        </table>
                        
                        <br>
                        <br>

					<div class="form-group text-center">
						<button type="submit" class="btn btn-primary pull-right mr-3">Update</button>
		
					</div>

				</div>

			</div>
		</div>
	</div>
</form>

@endsection
