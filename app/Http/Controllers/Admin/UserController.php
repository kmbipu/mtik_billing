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
    
    public function customerList(){
        $args = $this->filter();
        $rs = new RoleService();
        $args['role_id'] = $rs->search(['slug'=>'customer'])->first()->id;
        $query = request('query');
        $users = $this->service->search($args,$query,true);
        return view('admin.user.customer_list', array('users'=>$users));
    }

    public function resellerList(){
        $args = $this->filter();
        $rs = new RoleService();
        $rs = new RoleService();
        $args['role_id'] = $rs->search(['slug'=>'reseller'])->first()->id;
        $query = request('query');
        $users = $this->service->search($args,$query,true);
        $roles = RoleService::getAll();
        return view('admin.user.reseller_list', array('users'=>$users,'roles'=>$roles));
    }

    public function addCustomer(Request $request){
        if($request->method()=='POST'){
            if($this->service->insert($request->all()))
                return back();            
        }
        $rs = new RoleService();
        $role = $rs->search(['slug'=>'customer'])->first();
        return view('admin.user.add_customer',array('role'=>$role));
    }
    
    public function addReseller(Request $request){
        if($request->method()=='POST'){
            if($this->service->insert($request->all()))
                return back();
        }
        $rs = new RoleService();
        $role = $rs->search(['slug'=>'reseller'])->first();
        return view('admin.user.add_reseller',array('role'=>$role));
    }

    public function edit(Request $request, $id){
        if($request->method()=='POST'){
            $this->service->update(['id'=>$id], $this->filter($request->all()));
            return back();
        } 
        $user = $this->service->find($id);
        $slug = RoleService::find($user->role_id)->slug;
        if($user)     
            return view('admin.user.edit', array('user'=>$user,'slug'=>$slug));
        else
            abort(404, "Not found");
    }


    public function delete($id){
        $this->service->delete($id);
        return back();
    }
}
