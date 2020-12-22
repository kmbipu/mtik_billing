<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prepaid;
use App\Services\Pear2Service;
use Illuminate\Support\Facades\DB;
use App\Services\Helper;
use App\Models\Setting;
use App\Services\SettingService;
use App\Services\SmsService;

class CronController extends Controller
{
    
    public function execute() {
        $this->disablePPPoe();
        $this->sendRemainderSMS();
    }
    
    
    private function disablePPPoe(){
        //Expire and Disable Part
        $pm = new Prepaid();
        $cd = date('Y-m-d');
        $prepaids = $pm->where('status',1)->where('expire_dt','<', $cd)->get();
        
        if($prepaids->count()==0){
            echo 'No expired accounts are found.<br>'; 
            return false;
        }
        $count=0;
        $phone = '';
        foreach ($prepaids as $p) {
            try{
                DB::beginTransaction();
                $p2s = new Pear2Service($p->router_id);
                $username = $p->user->username;
                $p2s->disablePPPoeUser($username);
                $pm->where('id',$p->id)->update(['status'=>0]);
                DB::commit();
                $phone = $phone. $p->user->phone. ',';
                $count++;
            }
            catch (\Exception $e){
                DB::rollBack();
                Helper::log('CRON-MSG = '.$e->getMessage());
            }
        }
        $phone = rtrim($phone,',');

        $this->sendDisableSMS($phone);
        
        echo 'Total Disabled - '.$count.'<br>';        
    }
    
    
    private function sendDisableSMS($phone){
        $setting = SettingService::find('sms');
        if($setting==null){
            return false;
        }
        
        $sms = json_decode($setting);
        if(empty($phone) || empty($sms->suspend_message) || empty($sms->suspend_message)){
            return false;
        }
        
        $ss = new SmsService();
        $ss->sendMessage($phone, $sms->suspend_message);
        
    }
    
    
    private function sendRemainderSMS(){
        
        //Payment sms remainder        
        try{            
            $setting = SettingService::find('sms');
            if($setting==null){
                return false;
            }
            
            $sms = json_decode($setting);
            if(empty($sms->before_expire_message) || empty($sms->before_expire)){
                return false;
            }
     
            $before_expire = $sms->before_expire;
            $before_expire_message = $sms->before_expire_message;
            
            $days = explode(',',$before_expire);
            $cd = date("Y-m-d");
            $pm = new Prepaid();
            $ss = new SmsService();
            
            $count = 0;
            foreach ($days as $k => $v){
                $expire_dt = date("Y-m-d", strtotime($cd . " + $v days"));
                $prepaids = $pm->where('status',1)->where('expire_dt', $expire_dt)->get();
                $phone = '';
                foreach ($prepaids as $p){
                    $phone = $phone.$p->user->phone.',';
                    $count++;
                }
                $phone = rtrim($phone,',');
                if($phone){
                    $message = str_replace('<expire_date>', $expire_dt, $before_expire_message);
                    $ss->sendMessage($phone, $message);
                }
            }
            echo 'Total Remainder SMS - '.$count.'<br>';
        }
        catch(\Exception $e){
            Helper::log('CRON-MSG = '.$e->getMessage());
        }        
        
    }
    
    
    
}
