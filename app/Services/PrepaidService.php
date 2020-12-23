<?php
namespace App\Services;

use App\Models\Prepaid;
use Illuminate\Support\Facades\Validator;
use App\Services\Helper;
use Session;
use Exception;
use Auth;
use Illuminate\Support\Facades\DB;

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
        $record = $record->orderBy('id','desc');
        if ($is_paginate)
            $records = $record->paginate($rows);
        else
            $records = $record->get();
        return $records;
    }

    public function insert($params, $call=false)
    {
        $validator = $this->validator($params);
        if ($validator->passes()) {
            try {
                $this->model->create($params); 
                $p2s = new Pear2Service($params['router_id']);
                $p2s->addPPPoeUser($params['username'], $params['password'], $params['plan_name']);
                
                return true;
            } catch (\Exception $e) {
                Helper::log($e->getMessage());
                if($call){
                    throw new Exception($error);
                }
                else{
                    Session::flash('error', $error);
                    return false;
                }
            }
        } else {            
            $error = Helper::errorToString($validator->errors()->all());
            if($call){
                throw new Exception($error);
            }                
            else{
                Session::flash('error', $error);
                return false;
            }            
        }
    }

    public function updateStatusExpire($id, $params)
    {
        try {
            DB::beginTransaction();
            $this->model->where(['id'=>$id])->update($params);
            $prepaid = $this->model->find($id);
            $username = $prepaid->user->username;
            $p2s = new Pear2Service($prepaid->router_id);
            if($params['status'])
                $p2s->enablePPPoeUser($username);
            else 
                $p2s->disablePPPoeUser($username);
            
            DB::commit();
            Session::flash('success', 'Successfully updated.');
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Helper::log($e->getMessage());
            Session::flash('error', 'Unable to update.');
            return false;
        }
        
    }
    
    public function update($condition, $params, $call=false)
    {
        try {
            $fill_data = $this->model->fill($params)->toArray();
            $this->model->where($condition)->update($fill_data);
            $p2s = new Pear2Service($params['router_id']);
            $p2s->deletePPPoeUser($params['username']);
            $p2s->addPPPoeUser($params['username'], $params['password'], $params['plan_name']);
            
            return true;
        } catch (\Exception $e) {
            Helper::log($e->getMessage());
            $error = 'Unable to update prepaid data.';
            if($call){
                throw new Exception($error);
            }
            else{
                Session::flash('error', $error);
                return false;
            } 
        }
        
    }

    public function delete($id)
    {
        try {
            $record = $this->model->find($id);
            $username= $record->user->username;
            $router_id = $record->router_id;
            $record->delete();
            $p2s = new Pear2Service($router_id);
            $p2s->deletePPPoeUser($username);
            
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
            DB::beginTransaction();
            
            
            $user_id = $params['prepaid']['user_id'];
            $prepaid = $this->model->where(['user_id'=>$user_id])->first();
            $plan = PlanService::find($params['prepaid']['plan_id']);
            $user = UserService::find($user_id);
            
            $params['prepaid']['username'] = $user->username;
            $params['prepaid']['password'] = $user->secret;
            $params['prepaid']['plan_name'] = $plan->name;
            
            
            $this->update($condition, $params['prepaid'], true);
            
            $trans = array(
                'user_id' => $params['prepaid']['user_id'],
                'username' => $user->username,
                'plan_name' => $plan->name,
                'amount' => $plan->price,
                'start_dt' => $params['prepaid']['start_dt'],
                'expire_dt' => $params['prepaid']['expire_dt'],
                'status' => $params['trans']['status'],
                'type' => $params['trans']['type'],
                'p_method' => $params['trans']['method'],
                'p_trxid' => $params['trans']['trxid'],
                'seller_id' => $plan->seller_id
            );

            $ts = new TransactionService();
            $ts->insert($trans, true);
            DB::commit();
            $this->sendRechargeSMS($user->id, $user->phone, $plan->price);
            Session::flash('success', 'Successfully renewed.');
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Helper::log($e->getMessage());
            Session::flash('error', 'Unable to renew now.');
            return false;
        }
    
    }

    public function recharge($params)
    {
         try {
            DB::beginTransaction();
            $user_id = $params['prepaid']['user_id'];
            $prepaid = $this->model->where(['user_id'=>$user_id])->first();
            $plan = PlanService::find($params['prepaid']['plan_id']);
            $user = UserService::find($user_id);
            
            $params['prepaid']['username'] = $user->username;
            $params['prepaid']['password'] = $user->secret;
            $params['prepaid']['plan_name'] = $plan->name;
            
            if ($prepaid)
                $this->update(['id' => $prepaid->id], $params['prepaid'], true);
            else
                $this->insert($params['prepaid'],true);

            
            $trans = array(
                'user_id' => $params['prepaid']['user_id'],
                'username' => $user->username,
                'plan_name' => $plan->name,
                'amount' => $plan->price,
                'start_dt' => $params['prepaid']['start_dt'],
                'expire_dt' => $params['prepaid']['expire_dt'],
                'status' => $params['trans']['status'],
                'type' => $params['trans']['type'],
                'p_method' => $params['trans']['method'],
                'p_trxid' => $params['trans']['trxid'],
                'seller_id' => $plan->seller_id
            );
            $ts = new TransactionService();
            $ts->insert($trans,true);
            
            DB::commit();
            $this->sendRechargeSMS($user->id, $user->phone, $plan->price);
            Session::flash('success', 'Successfully recharged.');
            return true;
            
        } catch (Exception $e) {
            DB::rollBack();
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
            'seller_id' => $plan->seller_id,
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
            'seller_id' => $plan->seller_id,
            'price' => $plan->price,
            'start_dt' => $prepaid->start_dt,
            'expire_dt' => $expire_dt
        );

        return (object) $data;
    }
    
    
    private function sendRechargeSMS($user_id, $phone, $amount){
        try{
        $setting = SettingService::find('sms');
        if($setting==null){
            return false;
        }
        
        $sms = json_decode($setting);
        if(empty($phone) || empty($sms->recharge_message) || empty($sms->recharge_message)){
            return false;
        }        
        $ss = new SmsService();
        $message = $sms->recharge_message;
        $message = str_replace('<id>', $user_id, $message);
        $message = str_replace('<amount>', $amount, $message);
        
        $ss->sendMessage($phone, $message);
        }
        catch (Exception $e){
            Helper::log($e->getMessage());
        }
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