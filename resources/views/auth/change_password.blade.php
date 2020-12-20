@extends('layouts.main') 

@section('pageTitle', 'Change Password')

@section('content')

<div class="row">
	<div class="col-md-6 mb-4">
		<!-- Simple Tables -->
		<div class="card">
			<div class="card-body">
				<form method="post">
					@csrf
					<div class="form-group">
						<label for="input_role_name">Current Password</label> 
						<input name="current_password"	type="password" class="form-control" placeholder="Enter current password" required>
					</div>
					
					<div class="form-group">
						<label for="input_role_name">New Password</label> 
						<input minlength="8" name="new_password"	type="password" class="form-control" placeholder="Enter new password" required>
					</div>
					
					<div class="form-group">
						<label for="input_role_name">Confirm New Password</label> 
						<input minlength="8" name="confirm_password"	type="password" class="form-control" placeholder="Confirm new password" required>
					</div>
					<br>
					<button type="submit" class="btn btn-primary">Update</button>

				</form>
			</div>

		</div>
	</div>
</div>

@endsection
