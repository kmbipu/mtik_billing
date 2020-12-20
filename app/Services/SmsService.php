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
        $role = $this->model->where($params);
        if(!empty($str)){
            $role = $role->where(function($query) use ($str) {
                $query->orWhere('name','like',$str.'%');
            });
        }
        if($is_paginate)
            $roles = $role->paginate($rows);
        else
            $roles = $role->get();

        return $roles;
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

    
    public function sendSingle($phone,$message){
        if($phone=='' || $phone==null || $message=='' || $message==null){
            Session::flash('error','Invalid phone or message');
            return false;
        }        
        try{
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
            
            $cus_role = $rs->search(['slug'=>'customer'])->first()->id;
            $res_role = $rs->search(['slug'=>'reseller'])->first()->id;
            
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
            
            foreach ($users as $u){
                $result = $gs->sendSMS($u->phone, $message);
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