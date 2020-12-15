<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PermissionService;
use Route;

class PermissionController extends Controller
{
    public function index(){
        $result = PermissionService::search(request()->role_id);
         return view('admin.permission.index', $result);
    }

    public function refresh()
    {
        PermissionService::refreshReload();
        return redirect('admin/permissions');
    }

    public function deleteAssign(Request $request){
        $data = $request->all();
        $action = $data['action'];
        $role_id = $data['role_id'];
        $ids = $data['permissions'];
        if($action=='1')         
            PermissionService::deleteMultiple($ids);
        elseif($action=='2')
            PermissionService::assignRole($role_id, $ids);
        return back();
    }

}
