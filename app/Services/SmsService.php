<?php

namespace App\Services;

use App\Models\SMS;
use Session;
use Exception;
use Auth;

class SmsService
{

    private $model;

    public function __construct()
    {
        $this->model = new SMS();
    }

    public static function find($id){
        return SMS::find($id);
    }

    public static function getAll(){
        return SMS::get();
    }

    public function search($params=[], $str="", $is_paginate = false, $rows = 15){
        $record = $this->model->where($params);
        if(!empty($str)){
            $record = $record->where(function($query) use ($str) {
                $query->orWhere('name','like',$str.'%');
            });
        }
        $record = $record->orderBy('id','desc');
        if($is_paginate)
            $records = $record->paginate($rows);
        else
            $records = $role->get();

            return $records;
    }

    public function insert($params){
        try{
            $this->model->create($params);
            Session::flash('success','Successfully added.');
            return true;
        }
        catch (Exception $e){
            Helper::log($e->getMessage());
            Session::flash('error', "Unable to add.");
            return false;
        }
    }
    
    public function sendMessage($phone,$message){        
        if($phone=='' || $phone==null || $message=='' || $message==null){
            return false;
        }
        try{
            
            $setting = SettingService::find('sms');
            if($setting==null){
                Session::flash('error','SMS Settings is Inactive.');
                return false;
            }
            $sms = json_decode($setting);
            if(!isset($sms->status) || empty($sms->status) || $sms->status==0){
                Session::flash('error','SMS Settings is Inactive.');
                return false;
            }
            
            $gs = new GatewayService();
            $result = $gs->sendSMS($phone, $message);
            if($result)
                $data = array('phone'=>$phone,'message'=>$message,'status'=>1);
            else
                $data = array('phone'=>$phone,'message'=>$message,'status'=>0,'reason'=>$gs->error);            
            $this->model->create($data);
            return true;
        }
        catch (Exception $e){
            Helper::log($e->getMessage());
            return false;
        }        
    } 
    
    
    public function sendSingle($phone,$message){
        if($phone=='' || $phone==null || $message=='' || $message==null){
            Session::flash('error','Invalid phone or message');
            return false;
        }        
        try{
            
            $setting = SettingService::find('sms');
            if($setting==null){
                Session::flash('error','SMS Settings is Inactive.');
                return false;
            }            
            $sms = json_decode($setting);
            if(!isset($sms->status) || empty($sms->status) || $sms->status==0){
                Session::flash('error','SMS Settings is Inactive.');
                return false;
            }
            
            
            $gs = new GatewayService();
            $result = $gs->sendSMS($phone, $message);
            if($result){
                $data = array('phone'=>$phone,'message'=>$message,'status'=>1);
                Session::flash('success','Successfully sent.');
            }
            else {
                $data = array('phone'=>$phone,'message'=>$message,'status'=>0,'reason'=>$gs->error);
                Session::flash('error',$gs->error);
            }
            
            $this->model->create($data);
            
            return true;
        }
        catch (Exception $e){
            Helper::log($e->getMessage());
            Session::flash('error', "Unable to send now.");
            return false;
        }     
        
    }    
    
    
    public function sendGroup($group,$message){
        
        if($group=='' || $group==null || $message=='' || $message==null){
            Session::flash('error','Invalid group or message');
            return false;
        }

        try{
            $us = new UserService();
            $rs = new RoleService();
            $gs = new GatewayService();
            
            $cus_role = $rs->search(['name'=>'customer'])->first()->id;
            $res_role = $rs->search(['name'=>'reseller'])->first()->id;
            
            $my_id = Auth::user()->id;
            
            if($group=='1'){
                $users = $us->search(['role_id'=>$cus_role,'created_by'=>$my_id]);
            }
            else if($group=='2'){
                $users = $us->search(['role_id'=>$cus_role]);
            }
            else if($group=='3'){
                $users = $us->search(['role_id'=>$res_role]);
            }
            
            $phone = '';
            foreach ($users as $u){
                $phone = $phone . $u->phone.',';               
            }
            $phone = rtrim($phone,',');
            
            if($phone){
                $result = $gs->sendSMS($phone, $message);
                if($result)
                    $data = array('phone'=>$phone,'message'=>$message,'status'=>1);
                else
                    $data = array('phone'=>$phone,'message'=>$message,'status'=>0,'reason'=>$gs->error);
                $this->model->create($data);
            }
            
            Session::flash('success','Successfully sent. Total sent - '.$users->count());
            
            return true;
        }
        catch (Exception $e){
            Helper::log($e->getMessage());
            Session::flash('error', "Unable to send now.");
            return false;
        }
        
    }


}