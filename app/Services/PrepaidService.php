<?php
namespace App\Services;

use App\Models\Prepaid;
use Illuminate\Support\Facades\Validator;
use App\Services\Helper;
use Session;
use Exception;
use Auth;

class PrepaidService
{

    private $model;
    private $error;

    public function __construct()
    {
        $this->model = new Prepaid();
    }

    public static function find($id)
    {
        return Prepaid::find($id);
    }

    public static function getAll()
    {
        return Prepaid::get();
    }

    public function search($params = [], $str = "", $is_paginate = false, $rows = 15)
    {
        $record = $this->model->select(['prepaids.status','prepaids.id','users.username','prepaids.start_dt','prepaids.expire_dt','users.created_by','prepaids.plan_id'])->leftJoin("users", 'users.id', '=', 'prepaids.user_id')->where($params);
        if (! empty($str)) {
            $record = $record->where(function ($query) use ($str) {
                $query->orWhere('users.name', 'like', $str . '%')
                    ->orWhere('users.username', 'like', $str . '%')
                    ->orWhere('prepaids.user_id', 'like', $str . '%');
            });
        }

        if ($is_paginate)
            $records = $record->paginate($rows);
        else
            $records = $record->get();
        return $records;
    }

    public function insert($params)
    {
        $validator = $this->validator($params);
        if ($validator->passes()) {
            try {
                $this->model->create($params);                
                return true;
            } catch (\Exception $e) {
                Helper::log($e->getMessage());
                $this->error = 'Unable to insert prepaid data.';
                return false;
            }
        } else {
            $this->error = Helper::errorToString($validator->errors()->all());
            return false;
        }
    }

    public function updateStatusExpire($condition, $params)
    {
        try {
            $this->model->where($condition)->update($params);   
            Session::flash('success', 'Successfully updated.');
            return true;
        } catch (\Exception $e) {
            Helper::log($e->getMessage());
            Session::flash('error', 'Unable to update.');
            return false;
        }
        
    }
    
    public function update($condition, $params)
    {
        try {
            $this->model->where($condition)->update($params);
            return true;
        } catch (\Exception $e) {
            Helper::log($e->getMessage());
            $this->error = 'Unable to update prepaid data.';
            return false;
        }
        
    }

    public function delete($id)
    {
        try {
            $record = $this->model->find($id);
            $record->delete();
            Session::flash('success', 'Successfully deleted.');
            return true;
        } catch (Exception $e) {
            Helper::log($e->getMessage());
            Session::flash('error', 'Unable to delete.');
            return false;
        }
    }

    public function renew($condition, $params)
    {        
        try {
            
            $this->update($condition, $params['prepaid']);
            
            $plan = PlanService::find($params['prepaid']['plan_id']);
            
            $trans = array(
                'user_id' => $params['prepaid']['user_id'],
                'username' => UserService::find($params['prepaid']['user_id'])->username,
                'plan_name' => $plan->name,
                'amount' => $plan->price,
                'start_dt' => $params['prepaid']['start_dt'],
                'expire_dt' => $params['prepaid']['expire_dt'],
                'status' => $params['trans']['status'],
                'type' => $params['trans']['type'],
                'p_method' => $params['trans']['method'],
                'p_trxid' => $params['trans']['trxid']
            );

            $ts = new TransactionService();
            $ts->insert($trans);
            
            Session::flash('success', 'Successfully renewed.');
            return true;
        } catch (Exception $e) {
            Helper::log($e->getMessage());
            Session::flash('error', 'Unable to renew now.');
            return false;
        }
    
    }

    public function recharge($params)
    {
         try {
            $prepaid = $this->model->where(['user_id'=>$params['prepaid']['user_id']])->first();
            if ($prepaid)
                $this->update(['id' => $prepaid->id], $params['prepaid']);
            else
                $this->insert($params['prepaid']);

            $plan = PlanService::find($params['prepaid']['plan_id']);
            $trans = array(
                'user_id' => $params['prepaid']['user_id'],
                'username' => UserService::find($params['prepaid']['user_id'])->username,
                'plan_name' => $plan->name,
                'amount' => $plan->price,
                'start_dt' => $params['prepaid']['start_dt'],
                'expire_dt' => $params['prepaid']['expire_dt'],
                'status' => $params['trans']['status'],
                'type' => $params['trans']['type'],
                'p_method' => $params['trans']['method'],
                'p_trxid' => $params['trans']['trxid'],
            );
            $ts = new TransactionService();
            $ts->insert($trans);
            Session::flash('success', 'Successfully recharged.');
            return true;
            
        } catch (Exception $e) {
            Helper::log($e->getMessage());
            Session::flash('error', 'Unable to recharge now.');
            return false;
        }
    }

    public function prepareRechargeReview($user_id, $plan_id)
    {
        $user = UserService::find($user_id);
        $plan = PlanService::find($plan_id);        
               
        $start_dt = date("Y-m-d");
        $expire_dt = date("Y-m-d", strtotime($start_dt . " + $plan->validity $plan->validity_unit"));
    
        $data = array(
            'name' => $user->name,
            'user_id' => $user->id,
            'username' => $user->username,
            'router_id' => $plan->router_id,
            'plan_id' => $plan_id,
            'plan_name' => $plan->name,
            'reseller_id' => $plan->reseller_id,
            'price' => $plan->price,
            'start_dt' => $start_dt,
            'expire_dt' => $expire_dt
        );

        return (object) $data;
    }

    public function prepareRenewReview($prepaid_id)
    {        
        $prepaid = $this->find($prepaid_id);
        $user = $prepaid->user;
        
        $plan = PlanService::find($prepaid->plan_id);
        $cd = date("Y-m-d");
        if($prepaid->expire_dt<$cd){
            $start_dt = date("Y-m-d");
            $expire_dt = date("Y-m-d", strtotime($start_dt . " + $plan->validity $plan->validity_unit"));
        }
        else{
            $start_dt = $prepaid->expire_dt;
            $expire_dt = date("Y-m-d", strtotime($start_dt . " + $plan->validity $plan->validity_unit"));
        }
        $data = array(
            'name' => $user->name,
            'user_id' => $user->id,
            'username' => $user->username,
            'router_id' => $plan->router_id,
            'plan_id' => $prepaid->plan_id,
            'plan_name' => $plan->name,
            'reseller_id' => $plan->reseller_id,
            'price' => $plan->price,
            'start_dt' => $prepaid->start_dt,
            'expire_dt' => $expire_dt
        );

        return (object) $data;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'user_id' => [
                'required',
                'integer','unique:prepaids'
            ],
            'router_id' => [
                'required',
                'integer'
            ],
            'plan_id' => [
                'required',
                'integer'
            ],
            'start_dt' => [
                'required',
                'string', 'max:100'],
            'expire_dt' => ['required', 'string', 'max:100']
        ]);
    }

}