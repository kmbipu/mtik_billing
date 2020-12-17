@extends('layouts.main') @section('pageTitle', 'Add Plan')

@section('content')

<form method="post">
	@csrf
	<div class="row">
		<div class="col-md-6 mb-4">
			<!-- Simple Tables -->
			<div class="card">

				<div class="card-body">
					<div class="form-group">
						<label>Plan Name</label> 
						<input value="{{request('name')}}" name="name" type="text" class="form-control" placeholder="Enter plan name" required>
					</div>

					<div class="form-group">
						<label for="exampleFormControlSelect1">Router</label> 
						<select id="select-router-for-pools" class="form-control" name="router_id" required>
							<option value="">Select Router</option>
							@foreach($routers as $router)
							<option value="{{$router->id}}" {{request('router_id')==$router->id?'selected':''}}>{{$router->name}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="exampleFormControlSelect1">Pool</label> 
						<select id="load-pools-by-router" class="form-control" name="pool_id" required>
							<option value="">Select Pool</option>
						</select>
					</div>

					<div class="form-group">
						<label for="exampleFormControlSelect1">Bandwidth</label> <select
							class="form-control" name="bandwidth_id" required>
							<option value="">Select Bandwidth</option> @foreach($bws as $bw)
							<option value="{{$bw->id}}" {{request('bandwidth_id')==$bw->id?'selected':''}}>{{$bw->name}}</option> @endforeach
						</select>
					</div>
					
					<div class="form-group">
						<label for="exampleFormControlSelect1">Admin/Reseller</label> 
						<select	class="form-control" name="reseller_id">
							<option value="">For Admin</option> 
							@foreach($resellers as $reseller)
							<option value="{{$reseller->id}}" {{request('reseller_id')==$reseller->id?'selected':''}}>{{$reseller->id}}-{{$reseller->name}}</option>
							@endforeach
						</select>
					</div>
				</div>

			</div>
		</div>
		<div class="col-md-6 mb-4">
			<!-- Simple Tables -->
			<div class="card">

				<div class="card-body">					
					
					<div class="form-group">
						<label>Price</label> 
						<input value="{{request('price')}}" name="price" type="number" class="form-control" placeholder="Enter price" required>
					</div>
					
					<div class="form-group">
						<label>Discount</label> 
						<input value="{{request('discount')}}" name="discount" type="number" class="form-control" placeholder="Enter discount(optional)">
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-sm-8">
    							<label>Validity</label> 
    							<input value="{{request('validity')}}" name="validity" type="number" class="form-control" placeholder="Enter validity" required>
							</div>
							<div class="col-sm-4">
								<label>Unit</label> 
								<select	class="form-control" name="validity_unit" required>
									<option value="days" {{request('validity_unit'=='days'?'selected':'')}}>Days</option>
									<option value="month" {{request('validity_unit'=='month'?'selected':'')}}>Month</option>
								</select>
							</div>
						</div>
					</div>

					<br>
					<div class="form-group text-center">
						<button type="submit" class="btn btn-primary pull-right mr-3">Create</button>
						<a href="{{url('admin/plans')}}"
							class="btn btn-default pull-right">Back</a>
					</div>

				</div>

			</div>
		</div>
	</div>
</form>

@endsection
