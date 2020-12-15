<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\RoleService;

class UserController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new UserService();
    }

    public function index(){
        $args = $this->filter();
        $query = request('query');
        $users = UserService::search($args,$query,true);
        $roles = RoleService::search();
        return view('admin.user.index', array('users'=>$users,'roles'=>$roles));
    }

    public function add(Request $request){
        if($request->method()=='POST'){
            if($this->model->insert($request->all()))
                return back();            
        }
        $roles = RoleService::search();     
        return view('admin.user.add',array('roles'=>$roles));
    }

    public function edit(Request $request, $id){
        if($request->method()=='POST'){
            $this->model->update(['id'=>$id], $this->filter($request->all()));
            return back();
        } 
        $user = UserService::find($id);
        $roles = RoleService::search();
        if($user)     
            return view('admin.user.edit', array('user'=>$user,'roles'=>$roles));
        else
            abort(404, "Not found");
    }


    public function delete($id){
        $this->model->delete($id);
        return back();
    }
}
