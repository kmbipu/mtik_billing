<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BandwidthService;
use Illuminate\Http\Request;
use App\Services\PlanService;
use App\Services\PoolService;
use App\Services\RouterService;
use App\Services\UserService;
use App\Services\Helper;

class PlanController extends Controller
{
    private $service;
    
    public function __construct()
    {
        $this->service = new PlanService();
    }

    public function list(){      
        $args = $this->filter();
        if($u=Helper::isReseller()){
            $args['seller_id'] = $u->id;
        }
        $query = request('query');
        $data = $this->service->search($args, $query, true);
        $sellers = (new UserService)->getSellers();
        return view('admin.plan.list', array('data'=>$data,'sellers'=>$sellers));
    }

    public function add(Request $request){
        if($request->method()=='POST'){
            if($this->service->insert($this->filter()))
                return back();            
        }
        $routers = RouterService::getAll();
        $bws = BandwidthService::getAll();        
        $sellers = (new UserService())->getSellers();
        return view('admin.plan.add',['routers'=>$routers,'bws'=>$bws,'sellers'=>$sellers]);
    }

    public function edit(Request $request, $id){
        if($request->method()=='POST'){
            $this->service->update(['id'=>$id], $this->filter($request->all()));
            return back();
        } 
        $data = $this->service->find($id);
        $routers = RouterService::getAll();
        $pools = (new PoolService())->search(['router_id'=>$data->router_id]);
        $bws = BandwidthService::getAll();
        $sellers = (new UserService())->getSellers();
        if($data)     
            return view('admin.plan.edit',['data'=>$data,'routers'=>$routers,'pools'=>$pools,'bws'=>$bws,'sellers'=>$sellers]);
        else
            abort(404, "Not found");
    }
    
    public function delete($id){
        $this->service->delete($id);
        return back();
    }
    
    public function getByRouter($router_id) {
        if(request('user_id')){
            $user = UserService::find(request('user_id'));
            $created_by = $user->created_by;
            $plans = $this->service->search(['router_id'=>$router_id,'seller_id'=>$created_by,'is_active'=>1]);
        }
        else{
            $plans = $this->service->search(['router_id'=>$router_id,'is_active'=>1]);
        }
        return $plans;
    }
}
