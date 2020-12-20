@extends('layouts.main') @section('pageTitle', 'Send SMS')


@section('content')

<div class="row">
	<div class="col-md-6 mb-4">
		<!-- Simple Tables -->
		<div class="card">
			<div class="card-header">Single SMS</div>
			<div class="card-body">
				<form method="post">
					@csrf
					<input type="hidden" name="single_group" value="single">
					<div class="form-group">
						<label for="input_role_name">Phone</label> 
						<input name="phone"	type="tel" class="form-control" placeholder="Enter phone number" required>
					</div>
					
					<div class="form-group">
						<label for="input_role_name">Message</label> 
						<textarea name="message" class="form-control" placeholder="Enter message here" required></textarea>
					</div>
					
					<button type="submit" class="btn btn-primary">Send</button>


				</form>
			</div>

		</div>
	</div>
	
	<div class="col-md-6 mb-4">
		<!-- Simple Tables -->
		<div class="card">
			<div class="card-header">Group SMS</div>
			<div class="card-body">
				<form method="post">
					@csrf
					<input type="hidden" name="single_group" value="group">
					<div class="form-group">
                        <label for="exampleFormControlSelect1">Group</label>
                        <select class="form-control"  name="group" required>
                            <option value="">Select Group</option>
                            <option value="1">My Customers</option>
                            <option value="2">All Customers</option>
                            <option value="3">Resellers</option>
                        </select>
                    </div>
					
					<div class="form-group">
						<label for="input_role_name">Message</label> 
						<textarea name="message" class="form-control" placeholder="Enter message here" required></textarea>
					</div>
					
					<button type="submit" class="btn btn-primary">Send</button>


				</form>
			</div>

		</div>
	</div>
</div>

@endsection
