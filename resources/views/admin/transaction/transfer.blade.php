@extends('layouts.main')
@section('pageTitle', 'Fund Transfer')
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
                        <label for="exampleFormControlSelect1">Reseller</label>
                        <select class="form-control select2-single"  name="user_id" required>
                        <option value="">Select Reseller</option>
                        @foreach($resellers as $r)
                        <option value="{{$r->id}}" >{{$r->id.'-'.$r->username}}</option>
                        @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Payment Method</label>
                        <select class="form-control select2-single"  name="p_method" required>
                        <option value="">Select Method</option>
                        <option value="bkash">Bkash</option>
                        <option value="cash">Cash</option>
                        </select>
                    </div>
              
                               
                    <div class="form-group">
                      <label>Amount</label>
                      <input value="{{request('amount')}}" name="amount" type="number" class="form-control" placeholder="Enter amount" required>
                    </div>                    
                    
                    
                    <div class="form-group">
						<label>Transaction ID</label> 
						<input name="p_trxid" type="text"
							class="form-control" placeholder="Enter trx. id" required>
					</div>
					
					<div class="form-group">
						<label>Notes</label>
						<textarea name="p_notes" class="form-control" placeholder="Write note (optional)"></textarea>
				
					</div>                  
                    
                    <br>
                    <div class="form-group text-center">
                      <button type="submit" class="btn btn-primary pull-right mr-3">Transfer</button>
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

