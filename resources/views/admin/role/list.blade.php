@extends('layouts.main') @section('pageTitle', 'All Roles')

@section('headerRight')
<a class="btn btn-sm btn-primary btn-md my-0 ml-sm-2"
	href="{{url('admin/roles/add')}}"><i class="fas fa-plus"></i> Add New</a>
@endsection @section('content')
<div class="row">
	<div class="col-lg-12 mb-4">
		<!-- Simple Tables -->
		<div class="card">
			<div class="table-responsive">
				<table class="table align-items-center table-flush table-td-sm">
					<thead class="thead-light">
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Prefix</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($roles as $role)
						<tr>
							<td>{{ $role->id }}</td>
							<td>{{ $role->name }}</td>
							<td>{{ $role->prefix }}</td>
							<td><a href="{{url("admin/roles/edit").'/'.$role->id }}"
									class="btn btn-sm btn-warning">Edit</a> <a d_id="{{$role->id}}"
								d_action="{{url('/admin/roles/delete/'.$role->id)}}" href="#"
								class="btn btn-sm btn-danger delete-action-btn">Delete</a></td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="card-footer"></div>
		</div>
	</div>
</div>

@endsection
