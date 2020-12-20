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
    
    public function custom_search($start_date, $end_date, $created_by, $str){
        
        $record =  $this->model->where([]);
        
        if($created_by)
            $record =  $record->where(['created_by'=>$created_by]);
    
        if($start_date && $end_date){
            $start_date = $start_date.' 00:00:00';
            $end_date = $end_date.' 23:59:59';
            $record = $record->where('created_at','>=', $start_date)->where('created_at','<=',$end_date);
        }
        
        
        if($str){
            $record = $record->where(function($query) use ($str) {
                $query->orWhere('username','like',$str.'%')
                ->orWhere('id','like',$str.'%');
            });
        }
        
        $data = array();
        
        $data['total']= $record->sum('amount');
        
        $data['data'] = $record->paginate(15);
                
        return $data;
        
    }

    public function insert($params, $call=false){
        $validator = $this->validator($params);
        if ($validator->passes()) {           
            try{
                $params['created_by'] = Auth::user()->id;
                $this->model->create($params);
                return true;
            }
            catch (\Exception $e){
                Helper::log($e->getMessage());
                $error = "Unable to create transaction.";
                if($call){
                    throw new Exception('$error');
                }
                else{
                    Session::flash('error', $error);
                    return false;
                } 
            }
        }
        else{
            $error = Helper::errorToString($validator->errors()->all());
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
        ]);

    }

}