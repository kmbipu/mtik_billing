@extends('layouts.main') @section('pageTitle', 'Add Role')

@section('headerRight')
<a class="btn btn-sm btn-primary btn-md my-0 ml-sm-2"
	href="{{url('admin/roles')}}"><i class="fas fa-bars"></i> List</a>
@endsection @section('content')

<div class="row">
	<div class="col-md-6 mb-4">
		<!-- Simple Tables -->
		<div class="card">
			<div class="card-body">
				<form method="post">
					@csrf
					<div class="form-group">
						<label for="input_role_name">Name</label> 
						<input name="name"	type="text" class="form-control" placeholder="Enter a role name" required>
					</div>
					<div class="form-group">
						<label for="exampleFormControlSelect1">Role Type</label>
                        <select class="form-control"  name="slug" required>
                        <option value="">Select Type</option>
                        <option value="admin">Admin</option>
                        <option value="reseller">Reseller</option>
                        <option value="customer">Customer</option>
                        </select>					
					</div>
					<button type="submit" class="btn btn-primary">Create</button>
					<a href="{{url('admin/roles')}}" class="btn btn-default pull-right">Back</a>

				</form>
			</div>

		</div>
	</div>
</div>

@endsection
