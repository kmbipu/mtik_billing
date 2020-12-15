@extends('layouts.main')
@section('pageTitle', 'Add Pool')

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
                      <input name="name" type="text" class="form-control" placeholder="Enter pool name" required>
                    </div>
                    <div class="form-group">
                      <label>IP Range</label>
                      <input name="ip_range" type="text" class="form-control" placeholder="Enter IP range" required>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Router</label>
                        <select class="form-control"  name="router_id" required>
                        <option value="">Select Router</option>
                        @foreach($routers as $router)
                        <option value="{{$router->id}}" >{{$router->name}}</option>
                        @endforeach
                        </select>
                    </div>
                    <br>
                    <div class="form-group text-center">
                      <button type="submit" class="btn btn-primary pull-right mr-3">Create</button>
                      <a href="{{url('admin/pools')}}" class="btn btn-default pull-right">Back</a>
                    </div>
                    
              </div>        
              
          </div>
      </div>    
  </div>
</form>

@endsection