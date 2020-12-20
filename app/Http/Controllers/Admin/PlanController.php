<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BandwidthService;
use Illuminate\Http\Request;
use App\Services\PlanService;
use App\Services\PoolService;
use App\Services\RouterService;
use App\Services\UserService;

class PlanController extends Controller
{
    private $service;
    
    public function __construct()
    {
        $this->service = new PlanService();
    }

    public function list(){      
        $args = $this->filter();
        $query = request('query');
        $data = $this->service->search($args, $query);
        $resellers = (new UserService)->getResellers();
        return view('admin.plan.list', array('data'=>$data,'resellers'=>$resellers));
    }

    public function add(Request $request){
        if($request->method()=='POST'){
            if($this->service->insert($this->filter()))
                return back();            
        }
        $routers = RouterService::getAll();
        $bws = BandwidthService::getAll();        
        $resellers = (new UserService())->getResellers();
        return view('admin.plan.add',['routers'=>$routers,'bws'=>$bws,'resellers'=>$resellers]);
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
        $resellers = (new UserService())->getResellers();  
        if($data)     
            return view('admin.plan.edit',['data'=>$data,'routers'=>$routers,'pools'=>$pools,'bws'=>$bws,'resellers'=>$resellers]);
        else
            abort(404, "Not found");
    }
    
    public function delete($id){
        $this->service->delete($id);
        return back();
    }
    
    public function getByRouter($router_id) {        
        $plans = $this->service->search(['router_id'=>$router_id,'reseller_id'=>null]);
        return $plans;
    }
}
