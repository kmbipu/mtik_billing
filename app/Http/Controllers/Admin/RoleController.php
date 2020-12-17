<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RoleService;
use Session;

class RoleController extends Controller
{

    private $service;

    public function __construct()
    {
        $this->service = new RoleService();
    }

    public function index(){
        $roles = $this->service->search();
        return view('admin.role.index', array('roles'=>$roles));
    }

    public function add(Request $request){
        if($request->method()=='POST'){
            $this->service->insert($this->filter($request->all));
            return back();
        }
        
        return view('admin.role.add');
    }

    public function edit(Request $request, $id){
        if($request->method()=='POST'){
            $this->service->update(['id'=>$id], $this->filter($request->all()));
            return back();
        } 
        $role = $this->service->find($id);
        if($role)     
            return view('admin.role.edit', array('role'=>$role));
        else
            abort(404, "Not found");
    }

    public function delete($id){
        $this->service->delete($id);
        return back();
    }

}
