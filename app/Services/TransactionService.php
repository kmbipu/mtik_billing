<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Services\Helper;
use Session;
use Exception;
use App\Models\Role;
use App\Models\Transaction;
use Auth;

class TransactionService
{

    private $model;

    public function __construct()
    {
        $this->model = new Transaction();
    }

    public static function find($id){
        return Transaction::find($id);
    }

    public static function getAll(){
        return Transaction::get();
    }

    public function search($params=[], $str="", $is_paginate = false, $rows = 15){
        $record =  $this->model->where($params);
        if(!empty($str)){
            $record = $record->where(function($query) use ($str) {
                $query->orWhere('username','like',$str.'%')
                ->orWhere('id','like',$str.'%')
                ->orWhere('p_method','like',$str.'%');
            });
        }
        if($is_paginate)
            $records = $record->paginate($rows);
        else
            $records = $record->get();

        return $records;
    }
    
    public function custom_search($params, $str, $start_date, $end_date){
        $record =  $this->model->where($params);

        if($u=Helper::isReseller()){
            $q = ['user_id'=>$u->id, 'seller_id'=>$u->id];
            $record = $record->where(function($query) use ($q) {
                $query->orWhere($q);
            });
        }

        if(isset($params['seller_id']))
            $record =  $record->where(['seller_id'=>$params['seller_id']]);
    
        if($start_date && $end_date){
            $start = $params['start_date'].' 00:00:00';
            $end = $end_date.' 23:59:59';
            $record = $record->where('created_at','>=', $start)->where('created_at','<=',$end);
        }
        
        
        if($str){
            $record = $record->where(function($query) use ($str) {
                $query->orWhere('username','like',$str.'%')
                ->orWhere('id','like',$str.'%')
                ->orWhere('type','like',$str.'%')
                ->orWhere('p_method','like',$str.'%')
                ->orWhere('p_trxid','like',$str.'%')
                ->orWhere('plan_name','like',$str.'%');
            });
        }
        $record = $record->orderBy('id','desc');

        $data = array();        
        $data['total_recharge']= $record->get()->where('type','recharge')->sum('amount');
        $data['total_transfer']=  $record->get()->where('type','transfer')->sum('amount');
        $data['total_commission']= $record->get()->where('type','commission')->sum('amount');
        
        $data['data'] = $record->paginate(15);
                
        return $data;
        
    }

    public function insert($params, $call=false){
        $validator = $this->validator($params);
        if ($validator->passes()) {           
            try{
                $params['created_by'] = Auth::user()->id;                
                $this->model->create($params);
                $this->addCommission($params);
                return true;
            }
            catch (\Exception $e){
                Helper::log($e->getMessage());
                $error = "Unable to create transaction.";                
                if($call)
                    throw new Exception($error);             
                Session::flash('error', $error);
                return false;
                
            }
        }
        else{            
            $error = Helper::errorToString($validator->errors()->all());
            if($call)
                throw new Exception($error);
            Session::flash('error',$error);            
            return false;
        }
    }

    public function update($condition, $params){
        try{
            $this->model->where($condition)->update($params);
            Session::flash('success','Successfully updated.');
            return true;
        }
        catch (\Exception $e){
            Helper::log($e->getMessage());
            Session::flash('error','Unable to update.');
            return false;
        }
    }

    public function delete($id){
        try{
            $this->model->find($id)->delete();
            Session::flash('success','Successfully deleted.');
            return true;
        }
        catch (Exception $e){
            Helper::log($e->getMessage());
            Session::flash('error', 'Unable to delete.');
            return false;
        }
    }
    
    public function transfer($params) {
        
        $params['seller_id'] = Auth::user()->id;
        $params['created_by'] = $params['seller_id'];
        $params['plan_name'] = 'Transfer';
        try{
            $this->model->create($params);
            $user = UserService::find($params['user_id']);
            $user->update(['balance'=>$user->balance + $params['amount']]);
            Session::flash('success','Successfully transferred.');
            return true;
        }
        catch (\Exception $e){
            Helper::log($e->getMessage());
            Session::flash('error', 'Unable transfer now.');
            return false;
        }
    }
    
    public function prepareTransferReview()
    {
        $user = UserService::find(request('user_id'));

        $tmp = array(
            'name' => $user->name,
            'user_id' => $user->id,
            'username' => $user->username,
        );
        $post = request()->all();
        $data = array_merge($tmp,$post);
        
        return (object) $data;
    }
    
    public function addCommission($params){
        try{
            if($params['type']!='recharge')
                return false;        
    
            $user = UserService::find($params['user_id']);
            $seller = UserService::find($user->created_by);
            if($seller->role->name=='reseller'){
                $data = array(
                    'user_id' => $seller->id,
                    'username' => $seller->username,
                    'plan_name' => "Commission. Ref-".$params['user_id'],
                    'amount' => $params['discount'],
                    'status' => 'complete',
                    'type' => 'commission',
                    'p_method' => 'cash',
                    'p_trxid' => '1234',
                    'seller_id' => $seller->id,
                    'created_by' =>$params['created_by']
                );
                $this->model->create($data);
            }
            $seller->update(['balance'=>$seller->balance + $params['discount']]);
        }
        catch(\Exception $e){
            throw new Exception($e->getMessage());
        }
    }


    protected function validator(array $data){   
      
        return Validator::make($data, [
            'user_id' => ['required', 'integer'],
            'username' => ['required', 'string', 'max:255'],
            'plan_name' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'integer'],
            'start_dt' => ['required', 'string'],
            'expire_dt' => ['required', 'string'],
            'status' => ['required', 'string'],
            'type' => ['required', 'string'],
            'p_trxid' => ['required', 'string'],
            'p_method' => ['required', 'string'],
            'seller_id' =>['required', 'integer'],
        ]);

    }

}