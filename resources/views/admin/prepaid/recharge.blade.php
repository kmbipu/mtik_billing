@extends('layouts.main') 
@section('pageTitle', 'Recharge')

@section('topScripts')
  <link href="{{ asset('resources/assets/vendor/select2/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')

<form method="post">
	<input type="hidden" name="action" value="review">
	@csrf
	<div class="row">
		<div class="col-md-6 mb-4">
			<!-- Simple Tables -->
			<div class="card">

				<div class="card-body">	
				
					<div class="form-group">
                        <label for="exampleFormControlSelect1">Customer</label>
                        <select class="form-control select2-single"  name="user_id" required>
                        <option value="">Select Customer</option>
                        @foreach($users as $user)
                        <option value="{{$user->id}}" >{{$user->username}}</option>
                        @endforeach
                        </select>
                    </div>				
					
					<div class="form-group">
						<label for="exampleFormControlSelect1">Router</label> 
						<select id="select-router-for-plans" class="form-control" name="router_id" required>
							<option value="">Select Router</option> @foreach($routers as
							$router)
							<option value="{{$router->id}}">{{$router->name}}</option>
							@endforeach
						</select>
					</div>
					
					<div class="form-group">
						<label for="exampleFormControlSelect1">Plan</label> 
						<select id="load-plans-by-router" class="form-control" name="plan_id" required>
							<option value="">Select Plan</option>
						</select>
					</div>				

					<br>
					<div class="form-group text-center">
						<button type="submit" class="btn btn-primary pull-right mr-3">Recharge</button>
						<a href="{{url('admin/prepaids')}}"
							class="btn btn-default pull-right">Back</a>
					</div>

				</div>

			</div>
		</div>
	</div>
</form>

@endsection

@section('bottomScripts')
    <script src="{{ asset('resources/assets/vendor/select2/select2.min.js') }}"></script>
    <script>
    $('.select2-single').select2();
    </script>
@endsection
