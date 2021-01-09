<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PrepaidService;
use App\Services\PoolService;
use App\Services\RouterService;
use App\Services\UserService;
use App\Services\PlanService;
use App\Services\Helper;

class PrepaidController extends Controller
{
    
    private $service;
    
    public function __construct()
    {
        $this->service = new PrepaidService();
    }
    
    public function list(){
        $args = $this->filter();
        if($u=Helper::isReseller()){
            $args['created_by'] = $u->id;
            $plans = (new PlanService())->search(['seller_id'=>$u->id]);
        }
        else {
            $plans = PlanService::getAll();
        }
        
        $query = request('query');
        $data = $this->service->search($args, $query, true);
        $sellers = (new UserService)->getSellers();        
        return view('admin.prepaid.list', array('data'=>$data,'sellers'=>$sellers,'plans'=>$plans));
    }
    
    public function recharge(Request $request){
        if($request->method()=='POST'){
            $action = $request->action;
        
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
        }
        if(Helper::isAdmin()){
            $users = UserService::getCustomers();
        }
        else{
            $users = UserService::getCustomers(true);
        }
        $routers = RouterService::getAll();
        return view('admin.prepaid.recharge',['users'=>$users,'routers'=>$routers]);
    }
    
    public function renew(Request $request,$prepaid_id){
        if($request->method()=='POST'){            
            if($this->service->renew(['id'=>$prepaid_id],$request->all()))
                return redirect('/admin/prepaids/');
        }
        $data = $this->service->prepareRenewReview($prepaid_id);
        return view('admin.prepaid.renew',['data'=>$data]);
    }
    
    
    
    public function edit(Request $request, $id){
        if($request->method()=='POST'){
            $this->service->updateStatusExpire($id, $this->filter($request->all()));
            return back();
        }
        $data = $this->service->find($id);
        if($data)
            return view('admin.prepaid.edit', array('data'=>$data));
            else
                abort(404, "Not found");
    }
    
    public function delete($id){
        $this->service->delete($id);
        return back();
    }
    
    
}
