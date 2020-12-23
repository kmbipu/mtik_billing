<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\RoleService;
use App\Services\PrepaidService;
use App\Services\PlanService;
use App\Services\Helper;

class PageController extends Controller
{
    
    public function home() {
        $ps = new PlanService();
        $plans = $ps->search(['is_active'=>1,'is_display'=>1]);
        return view('page.home',['plans'=>$plans]);
    }
    
    public function adminHome()
    {
        $us = new UserService();
        $rs = new RoleService();
        $pres = new PrepaidService();
        $pls = new PlanService();
        
        $data = array();
        
        if($user=Helper::isAdmin()){           
            
            $cus_role = $rs->search(['name'=>'customer'])->first()->id;
            $res_role = $rs->search(['name'=>'reseller'])->first()->id;
            $ad_role = $rs->search(['name'=>'admin'])->first()->id;            
            
            $data['total_admin'] = $us->search(['role_id'=>$ad_role])->count();
            $data['total_customer'] = $us->search(['role_id'=>$cus_role])->count();
            $data['total_reseller'] = $us->search(['role_id'=>$res_role])->count();
            $data['total_pppoe'] = $pres->search(['status'=>1])->count();
            $data['total_plan'] = $pls->search(['is_active'=>1,'seller_id'=>$user->id])->count();
            
            return view('admin.admin_home', $data);
        }
        
        if($user = Helper::isReseller()){
            
            $data['total_customer'] = $us->search(['created_by'=>$user->id])->count();
            $data['total_pppoe'] = $pres->search(['status'=>1,'created_by'=>$user->id])->count();
            $data['total_plan'] = $pls->search(['is_active'=>1,'seller_id'=>$user->id])->count();
            
            return view('admin.reseller_home', $data);
        }
        
    }



    public function customerHome()
    {
        return 'Customer home'; 
    }
}
