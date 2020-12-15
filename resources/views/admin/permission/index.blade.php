@extends('layouts.main')
@section('pageTitle', 'All Permissions')
@section('headerRight')
<form class="form-inline ml-auto ng-pristine ng-valid" method="get" action="">
    <div class="md-form my-0 mr-2">
        <select id="User Type" name="role_id" class="form-control form-control-sm">
            <option value="">Select Role</option>
            @php $sel_role_id = isset($_GET['role_id'])?$_GET['role_id']:''; @endphp
            @foreach($roles as $role)
            <option value="{{$role->id}}" {{ $sel_role_id==$role->id?'selected':''}}>{{$role->name}}</option>
            @endforeach
        </select>
    </div>
    <button href="#" class="btn btn-sm btn-primary btn-md my-0 ml-sm-2" type="submit"><i class="fa fa-search"></i></button>
    <a href="{{url('admin/permissions/refresh')}}" class="btn btn-sm btn-default btn-md my-0 ml-sm-2" type="submit"><i class="fa fa-search"></i> Refresh</a>

</form>
@endsection

@php
function check_permission_role($permission_id, $role_id, $pr){
    foreach($pr as $k){
        if($k->role_id == $role_id && $k->permission_id==$permission_id){
            echo 'checked';break;
        }
    }
}
@endphp
@section('content')
<form method="post" action="{{url('admin/permissions/delete-assign')}}">
    <input type="hidden" name="role_id" value="{{$sel_role_id}}"/>
    @csrf
    <div class="row">
        <div class="col-lg-12 mb-4">
            <!-- Simple Tables -->
            <div class="card">            
                <div class="card-body">
                    <div class="row">
                        @foreach($permissions as $permission)
                        <div class="col-md-3 mb-2">
                            <div>
                            <input type="checkbox" id="permission[{{$permission->id}}]" name="permissions[]" value="{{$permission->id}}" {{ check_permission_role($permission->id, $sel_role_id,$permission_roles)}}>
                            <label for="permission[{{$permission->id}}]">{{$permission->name}}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>           
                <div class="card-footer" style="border-top:1px solid gainsboro;">
                   <div class="row">
                        <div class="col-md-3">
                            <select name="action" class="form-control form-control-sm" required>
                                    <option value=''>Select Action</option>
                                    <option value="1">Delete</option>
                                    <option value="2">Assign to Role</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button href="#" class="btn btn-sm btn-default btn-md my-0 ml-sm-2" type="submit">Confirm</button>
                        </div>
                   </div>
                </div>
            </div>        
        </div>
    </div>
</form>

@endsection