@extends('layouts.main') @section('pageTitle', 'SMS Setting')


@section('content')

<div class="row">
	<div class="col-md-6 mb-4">
		<!-- Simple Tables -->
		<div class="card">
			<div class="card-body">
				<form method="post">					
					@csrf
					<div class="form-group">
						<label for="input_role_name">Before Expire</label> 
						<input value="{{$before_expire}}" name="before_expire"	type="text" class="form-control" placeholder="In days(Ex.4,6)" >
					</div>
					
					<div class="form-group">
						<label for="input_role_name">Before Expire Message</label> 
						<textarea name="before_expire_message" class="form-control" placeholder="Enter message here" >{{$before_expire_message}}</textarea>
						<small><pre>Dynamic fields- &lt;expire_date&gt;</pre></small>
					</div>
					
					<div class="form-group">
						<label for="input_role_name">Suspend Message</label> 
						<textarea name="suspend_message" class="form-control" placeholder="Enter message here" >{{$suspend_message}}</textarea>
					</div>
					
					<div class="form-group">
						<label for="input_role_name">Recharge Message</label> 
						<textarea name="recharge_message" class="form-control" placeholder="Enter message here" >{{$recharge_message}}</textarea>
						<small><pre>Dynamic fields- &lt;id&gt;,&lt;amount&gt; </pre></small>
					</div>
					
					<br>
					<button type="submit" class="btn btn-primary">Save</button>

				</form>
			</div>

		</div>
	</div>
	

</div>

@endsection
