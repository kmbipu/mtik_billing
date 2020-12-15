<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\RoleService;

class UserController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new UserService();
    }

    public function index(){
        $args = $this->filter();
        $query = request('query');
        $users = $this->service->search($args,$query,true);
        $roles = RoleService::getAll();
        return view('admin.user.index', array('users'=>$users,'roles'=>$roles));
    }

    public function add(Request $request){
        if($request->method()=='POST'){
            if($this->service->insert($request->all()))
                return back();            
        }
        $roles = RoleService::getAll();     
        return view('admin.user.add',array('roles'=>$roles));
    }

    public function edit(Request $request, $id){
        if($request->method()=='POST'){
            $this->service->update(['id'=>$id], $this->filter($request->all()));
            return back();
        } 
        $user = $this->service->find($id);
        $roles = RoleService::getAll();
        if($user)     
            return view('admin.user.edit', array('user'=>$user,'roles'=>$roles));
        else
            abort(404, "Not found");
    }


    public function delete($id){
        $this->service->delete($id);
        return back();
    }
}
