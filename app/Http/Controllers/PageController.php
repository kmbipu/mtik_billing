<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\RoleService;
use App\Services\PrepaidService;
use App\Services\PlanService;

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
        $ps = new PrepaidService();
        $cus_role = $rs->search(['slug'=>'customer'])->first()->id;
        $res_role = $rs->search(['slug'=>'reseller'])->first()->id;
        $ad_role = $rs->search(['slug'=>'admin'])->first()->id;
        
        $data = array();
        $data['total_admin'] = $us->search(['role_id'=>$ad_role])->count();
        $data['total_customer'] = $us->search(['role_id'=>$cus_role])->count();
        $data['total_reseller'] = $us->search(['role_id'=>$res_role])->count();
        $data['total_active'] = $ps->search(['status'=>1])->count();
        
        return view('admin.home', $data);
    }

    public function resellerHome()
    {
        return 'Reseller home';
    }

    public function customerHome()
    {
        return 'Customer home'; 
    }
}
