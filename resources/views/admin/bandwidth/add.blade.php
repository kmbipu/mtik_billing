@extends('layouts.main')
@section('pageTitle', 'Add Bandwidth')

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
                      <div class="row">
                        <div class="col-8">
                          <label>Download Rate</label>
                          <input name="rate_down" type="number" class="form-control" placeholder="Enter down rate" required>
                        </div>
                        <div class="col-4">
                        <label>Unit</label>
                          <select class="form-control"  name="rate_down_unit" required>
                            <option value="Kbps">Kbps</option>
                            <option value="Mbps">Mbps</option>
                          </select>
                        </div>
                      </div>                    
                    </div>                    

                    <div class="form-group">                    
                      <div class="row">
                        <div class="col-8">
                          <label>Up Rate</label>
                          <input name="rate_up" type="number" class="form-control" placeholder="Enter down rate" required>
                        </div>
                        <div class="col-4">
                        <label>Unit</label>
                          <select class="form-control"  name="rate_up_unit" required>
                            <option value="Kbps">Kbps</option>
                            <option value="Mbps">Mbps</option>
                          </select>
                        </div>
                      </div>
                    
                    </div>
                    
                    <br>
                    <div class="form-group text-center">
                      <button type="submit" class="btn btn-primary pull-right mr-3">Create</button>
                      <a href="{{url('admin/bandwidths')}}" class="btn btn-default pull-right">Back</a>
                    </div>
                    
              </div>        
              
          </div>
      </div>    
  </div>
</form>

@endsection