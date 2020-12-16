@extends('layouts.main') @section('pageTitle', 'Edit Role : '.$role->id)

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
						<label for="input_role_name">Name</label> <input name="name"
							type="text" class="form-control" placeholder="Enter a role name"
							value="{{ $role->name }}" required>
					</div>
					<div class="form-group">
						<label for="input_role_name">Name</label> <input name="name"
							type="text" class="form-control" placeholder="Enter a slug"
							value="{{ $role->slug }}" required>
					</div>
					
					<button type="submit" class="btn btn-primary">Update</button>
					<a href="{{ url(" /admin/roles") }}" class="btn btn-default">Back</a>
				</form>
			</div>

		</div>
	</div>
</div>

@endsection
