@extends('layouts.main') @section('pageTitle', 'SMS History')

@section('headerRight')
<form class="form-inline auto-align" method="get" action="">

    <div class="md-form auto-align">
        <input name="query" class="form-control form-control-sm" type="text" placeholder="Search here" aria-label="Search" value="{{request('query')}}">
    </div>
    <button href="#" class="btn btn-sm btn-primary auto-align" type="submit"><i class="fa fa-search"></i></button>
    <a class="btn btn-sm btn-primary btn-md my-0 ml-sm-2" href="{{url('admin/sms/send')}}"><i class="fas fa-plus"></i> Send</a>

</form>
@endsection


@section('content')
<div class="row">
	<div class="col-lg-12 mb-4">
		<!-- Simple Tables -->
		<div class="card">
			<div class="table-responsive">
				<table class="table align-items-center table-flush table-td-sm">
					<thead class="thead-light">
						<tr>
							<th>ID</th>
							<th>Phone</th>
							<th>Message</th>
							<th>Status</th>
							<th>Date</th>
						</tr>
					</thead>
					<tbody>
						@foreach($data as $d)
						<tr>
							<td>{{ $d->id }}</td>
							@php
							$sms = explode(',',$d->phone);
							if(count($sms)>1)
								$phone = count($sms).' numbers';
							else
							    $phone = $d->phone;
							@endphp
							<td>{{ $phone }}</td>
							<td>{{ $d->message }}</td>
							<td>
							@if($d->status)
							<span class="badge badge-success">Success</span>
							@else
							<span class="badge badge-danger">Failed</span>
							{{ $d->reason }}
							@endif
							</td>
							<td>{{ $d->created_at}}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
            <div class="card-footer">{{ $data->appends(request()->all())->links('paginator') }}</div>

		</div>
	</div>
</div>

@endsection
