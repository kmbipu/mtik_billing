@extends('layouts.main') 
@section('pageTitle', 'Recharge Review')

@section('content')

<form method="post">
@csrf
	<input type="hidden" name="action" value="recharge">
	<input type="hidden" name="prepaid[user_id]" value="{{$data->user_id}}">
	<input type="hidden" name="prepaid[router_id]" value="{{$data->router_id}}">
	<input type="hidden" name="prepaid[plan_id]" value="{{$data->plan_id}}">
	<input type="hidden" name="prepaid[start_dt]" value="{{$data->start_dt}}">
	<input type="hidden" name="prepaid[expire_dt]" value="{{$data->expire_dt}}">
	<input type="hidden" name="prepaid[status]" value="1">
	
	<div class="row">
		<div class="col-md-6 mb-4">
			<!-- Simple Tables -->
			<div class="card">
				<div class="card-header">
					Account & Plan
				</div>

				<div class="card-body">					
					
					
					<div class="table-responsive">
                        <table class="table table-td-sm table-bordered">  
                            <tbody>
                            	<tr><td>Name</td><td>{{$data->name}}</td><tr>
                            	<tr><td>Username</td><td>{{$data->username}}</td><tr>
                            	<tr><td>Plan</td><td>{{$data->plan_name}} = {{$data->price}}</td><tr>
                            
                            	<tr><td>Amount</td><td>{{$data->amount}}</td><tr>
                            	<tr><td>Commission</td><td>{{$data->commission}}</td><tr>
                            	<tr><td>Start Date</td><td>{{$data->start_dt}}</td><tr>
                            	<tr><td>Expire Date</td><td>{{$data->expire_dt}}</td><tr>
                            	
                            </tbody>
                        </table>
                        <br>
                        <br>
                    </div>						

				</div>

			</div>
		</div>
		
		<div class="col-md-6 mb-4">
			<!-- Simple Tables -->
			<div class="card">
				<div class="card-body">	
				
					<input type="hidden" name="trans[status]" value="complete">
					<input type="hidden" name="trans[type]" value="recharge">
				    <input type="hidden" name="trans[amount]" value="{{$data->amount}}">
				    <input type="hidden" name="trans[commission]" value="{{$data->commission}}">
				    
					<div class="form-group">
                        <label for="exampleFormControlSelect1">Payment Method</label>
                        <select class="form-control select2-single"  name="trans[method]" required>
                        <option value="">Select Method</option>
                        <option value="bkash">Bkash</option>
                        <option value="cash">Cash</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
						<label>Transaction ID</label> 
						<input name="trans[trxid]" type="text"
							class="form-control" placeholder="Enter trx. id" required>
					</div>
					
					<div class="form-group">
						<label>Notes</label>
						<textarea name="trans[notes]" class="form-control" placeholder="Write note (optional)"></textarea>
				
					</div>
				
					<br>
					<div class="form-group text-center">
						<button type="submit" class="btn btn-primary pull-right mr-3">Confirm Recharge</button>
						<a href="{{url('admin/prepaids/recharge')}}"
							class="btn btn-default pull-right">Back</a>
					</div>
				
				</div>
			</div>
		</div>
		
	</div>
</form>

@endsection

