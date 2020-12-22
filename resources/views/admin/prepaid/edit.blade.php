@extends('layouts.main') 
@section('pageTitle', 'Edit PPPoe User : '.$data->id)

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
                            	<tr><td>Name</td><td>{{$data->user->name}}</td><tr>
                            	<tr><td>Username</td><td>{{$data->user->username}}</td><tr>
                            	<tr><td>Plan</td><td>{{$data->plan->name}}</td><tr>                            	
                            	<tr><td>Expire Date</td><td><input class="form-control" name="expire_dt" value="{{$data->expire_dt}}"></td><tr>
                            	<tr>
                            		<td>Status</td>
                            		<td>
                            		<select class="form-control" name="status" required>
            							<option value="1" {{$data->status=='1'?'selected':''}}>Enable</option>
            							<option value="0" {{$data->status=='0'?'selected':''}}>Disable</option>
            						</select>
                            		</td>
								<tr>
                            </tbody>
                        </table>
                         <br>
                        <br>
                     </div>                         

					<div class="form-group text-center">
						<button type="submit" class="btn btn-primary pull-right mr-3">Update</button>
						<a href="{{url('admin/prepaids')}}"
							class="btn btn-default pull-right">Back</a>
					</div>

				</div>

			</div>
		</div>
	</div>
</form>

@endsection
