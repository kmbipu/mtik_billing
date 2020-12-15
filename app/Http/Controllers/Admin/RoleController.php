<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RoleService;
use Session;

class RoleController extends Controller
{

    private $model;

    public function __construct()
    {
        $this->model = new RoleService();
    }

    public function index(){
        $roles = $this->model->search();
        return view('admin.role.index', array('roles'=>$roles));
    }

    public function add(Request $request){
        if($request->method()=='POST'){
            $this->model->insert($request->all());
            return back();
        }        
        return view('admin.role.add');
    }

    public function edit(Request $request, $id){
        if($request->method()=='POST'){
            $this->model->update(['id'=>$id], $this->filter($request->all()));
            return back();
        } 
        $role = $this->model->find($id);
        if($role)     
            return view('admin.role.edit', array('role'=>$role));
        else
            abort(404, "Not found");
    }

    public function delete($id){
        $this->model->delete($id);
        return back();
    }

}
