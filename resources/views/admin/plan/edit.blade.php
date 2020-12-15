@extends('layouts.main')
@section('pageTitle', 'Edit Pool : '.$data->id)

@section('content')

<form method="post">
  @csrf
  <div class="row">
      <div class="col-md-6 mb-4">
          <!-- Simple Tables -->
          <div class="card">           
        
              <div class="card-body">                  
                    <div class="form-group">
                      <label>Name</label>
                      <input value="{{$data->name}}" name="name" type="text" class="form-control" placeholder="Enter router name" required>
                    </div>
                    <div class="form-group">
                      <label>IP Range</label>
                      <input value="{{$data->ip_range}}" name="ip_range" type="text" class="form-control" placeholder="Enter IP range" required>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Router</label>
                        <select class="form-control"  name="router_id" required>
                        <option value="">Select Router</option>
                        @foreach($routers as $router)
                        <option value="{{$router->id}}" {{ $data->router_id==$router->id?'selected':''}}>{{$router->name}}</option>
                        @endforeach
                        </select>
                    </div>
                    <br>
                    <div class="form-group text-center">
                      <button type="submit" class="btn btn-primary pull-right mr-3">Update</button>
                      <a href="{{url('admin/pools')}}" class="btn btn-default pull-right">Back</a>
                    </div>
                    
              </div>        
              
          </div>
      </div>    
  </div>
</form>

@endsection