<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PrepaidService;
use App\Services\PoolService;
use App\Services\RouterService;
use App\Services\UserService;
use App\Services\PlanService;

class PrepaidController extends Controller
{
    
    private $service;
    
    public function __construct()
    {
        $this->service = new PrepaidService();
    }
    
    public function index(){
        $args = $this->filter();
        $query = request('query');
        $data = $this->service->search($args, $query);
        return view('admin.prepaid.index', array('data'=>$data));
    }
    
    public function recharge(Request $request){
        if($request->method()=='POST'){
            $action = $request->action;
            if($action=='' || $action==null){
                return back();
            }            
            if($action=='review'){
                $data = $this->service->prepareRechargeReview($request->user_id, $request->plan_id);
                return view('admin.prepaid.recharge_review',['data'=>$data]);
            }
            else if($action=='recharge'){
                $this->service->recharge($this->filter());
                return redirect('/admin/prepaids/recharge');
            }
            else{
                return back();
            }
            
            if($this->service->insert($request->all()))
                return back();
        }
        
        $users = (new UserService())->getAdminUsers();
        $routers = RouterService::getAll();
        return view('admin.prepaid.recharge',['users'=>$users,'routers'=>$routers]);
    }
    
    
    
    public function edit(Request $request, $id){
        if($request->method()=='POST'){
            $this->service->update(['id'=>$id], $this->filter($request->all()));
            return back();
        }
        $data = $this->service->find($id);
        $routers = RouterService::getAll();
        if($data)
            return view('admin.prepaid.edit', array('data'=>$data,'routers'=>$routers));
            else
                abort(404, "Not found");
    }
    
    public function delete($id){
        $this->service->delete($id);
        return back();
    }
    
    
}
