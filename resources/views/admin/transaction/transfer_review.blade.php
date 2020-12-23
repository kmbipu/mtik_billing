@extends('layouts.main') 
@section('pageTitle', 'Fund Transfer Review')

@section('content')

<form method="post">
@csrf
	<input type="hidden" name="action" value="transfer">
	
	<input type="hidden" name="type" value="transfer">	
	<input type="hidden" name="user_id" value="{{$data->user_id}}">
	<input type="hidden" name="username" value="{{$data->username}}">
	<input type="hidden" name="status" value="complete">
	<input type="hidden" name="amount" value="{{$data->amount}}">
	<input type="hidden" name="p_method" value="{{$data->p_method}}">
	<input type="hidden" name="p_trxid" value="{{$data->p_trxid}}">
	<input type="hidden" name="p_notes" value="{{$data->p_notes}}">

	
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
                            	<tr><td>Amount</td><td>{{$data->amount}}</td><tr>
                            	<tr><td>Method</td><td>{{$data->p_method}}</td><tr>
                            	<tr><td>Trx. ID</td><td>{{$data->p_trxid}}</td><tr>
                            	<tr><td>Notes</td><td>{{$data->p_notes}}</td><tr>
                            </tbody>
                        </table>
                        <br>
                        <br>
                        
                        
                        <div class="form-group text-center">
                          <button type="submit" class="btn btn-primary pull-right mr-3">Confirm Transfer</button>
                        </div>
                        
                        
                    </div>						

				</div>

			</div>
		</div>
		
	</div>
</form>

@endsection

