<?php

namespace App\Services;

use App\Models\Prepaid;
use Illuminate\Support\Facades\Validator;
use App\Services\Helper;
use Session;
use Exception;


class PrepaidService
{
    private $model;

    public function __construct()
    {
        $this->model = new Prepaid();
    }

    public static function find($id){
        return Prepaid::find($id);
    }

    public static function getAll(){
        return Prepaid::get();
    }

    public function search($params=[], $str="", $is_paginate = false, $rows = 15){
        $record = $this->model->where($params);
        if(!empty($str)){
            $record = $record->where(function($query) use ($str) {
                $query->orWhere('name','like',$str.'%');
            });
        }
        if($is_paginate)
            $records = $record->paginate($rows);
        else
            $records = $record->get();

        return $records;
    }

    public function insert($params){
        $validator = $this->validator($params);
        if ($validator->passes()) {
            try{
                $this->model->create($params);
                Session::flash('success','Successfully added.');
                return true;
            }
            catch (\Exception $e){
                Session::flash('error', "Unable to add.");
                return false;
            }
        }
        else{
            $error = Helper::errorToString($validator->errors()->all());
            Session::flash('error',$error);            
            return false;
        }
    }

    public function update($condition, $params){
        $validator = $this->validator($params, true);
        if ($validator->passes()) {
            try{    
                
                $p2s = new Pear2Service($params['router_id']);
                $p2s->editPool($params['name'],$params['ip_range']);
                
                $this->model->where($condition)->update($params);
                Session::flash('success','Successfully updated.');
                return true;
            }
            catch (\Exception $e){
                Session::flash('error','Unable to update.');
                return false;
            }
        }
        else{
            $error = Helper::errorToString($validator->errors()->all());
            Session::flash('error',$error);            
            return false;
        }
    }

    public function delete($id){
        try{
            $record = $this->model->find($id);
            $record->delete();
            Session::flash('success','Successfully deleted.');
            return true;
        }
        catch (Exception $e){
            Session::flash('error', 'Unable to delete.');
            return false;
        }
    }
    
    public function recharge($params) {
        $this->insert($params['prepaid']);
    }
    
    public function prepareRechargeReview($user_id,$plan_id){
        $user = UserService::find($user_id);
        $plan = PlanService::find($plan_id);
        $start_dt  = date("Y-m-d");
        $expire_dt = date("Y-m-d", strtotime($start_dt. " + $plan->validity $plan->validity_unit"));
        
        $data = array(
            'name' => $user->name,
            'user_id'       => $user->id,
            'username'       => $user->username,
            'router_id'     => $plan->router_id,
            'plan_id'       => $plan_id, 
            'plan_name'     => $plan->name,
            'reseller_id'   => $plan->reseller_id,
            'price'         => $plan->price,
            'start_dt'      => $start_dt, 
            'expire_dt'     => $expire_dt 
        );
        
        return (object)$data;        
    }

    protected function validator(array $data){
        return Validator::make($data, [
            'user_id' => ['required', 'integer'],
            'router_id' => ['required', 'integer'],
            'plan_id' => ['required', 'integer'],            
            'start_dt' => ['required', 'string', 'max:100'],
            'expire_dt' => ['required', 'string', 'max:100']
        ]);
    }

}