<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PermissionService;
use Route;

class PermissionController extends Controller
{

    private $service;

    public function __construct()
    {
        $this->service = new PermissionService();
    }

    public function index(){
        $result = $this->service->search(request()->role_id);
         return view('admin.permission.index', $result);
    }

    public function refresh()
    {
        $this->service->refreshReload();
        return redirect('admin/permissions');
    }

    public function deleteAssign(Request $request){
        $data = $request->all();
        $action = $data['action'];
        $role_id = $data['role_id'];
        $ids = $data['permissions'];
        if($action=='1')         
            $this->service->deleteMultiple($ids);
        elseif($action=='2')
            $this->service->assignRole($role_id, $ids);
        return back();
    }

}
