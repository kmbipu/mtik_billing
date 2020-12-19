<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prepaid;
use App\Services\Pear2Service;
use Illuminate\Support\Facades\DB;
use App\Services\Helper;

class CronController extends Controller
{
    public function index() {
        $pm = new Prepaid();
        $cd = date('Y-m-d');
        $prepaids = $pm->where('status',1)->where('expire_dt','<', $cd)->get();
        
        if($prepaids->count()==0)
            return;
        
        $disable_count=0;
        foreach ($prepaids as $p) {
            try{
                DB::beginTransaction();
                $p2s = new Pear2Service($p->router_id);
                $username = $p->user->username;
                $p2s->disablePPPoeUser($username);            
                $pm->where('id',$p->id)->update(['status'=>0]);
                DB::commit();
                $disable_count++;
            }
            catch (\Exception $e){
                DB::rollBack();
                Helper::log('CRON-ERROR = '.$e->getMessage());
            }
        }
        
        
        return 'Total disabled - '.$disable_count;        
    }
}
