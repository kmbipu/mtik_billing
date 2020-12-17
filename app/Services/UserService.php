<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Services\Helper;
use Session;
use Exception;
use App\Models\Role;
use Auth;

class UserService
{

    private $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public static function find($id){
        return User::find($id);
    }

    public static function getAll(){
        return User::get();
    }
    
    public static function getOwnCustomers(){
        $role = Role::where('slug','customer')->first();
        $role_id = -1;
        if($role){$role_id= $role->id;}
        return User::where(['created_by'=>Auth::user()->id,'role_id'=>$role_id])->get();
    }

    public function search($params=[], $str="", $is_paginate = false, $rows = 15){
        $user =  $this->model->where($params);
        if(!empty($str)){
            $user = $user->where(function($query) use ($str) {
                $query->orWhere('name','like',$str.'%')
                ->orWhere('phone','like',$str.'%')
                ->orWhere('username','like',$str.'%');;
            });
        }
        if($is_paginate)
            $users = $user->paginate($rows);
        else
            $users = $user->get();

        return $users;
    }

    public function insert($params){
        $validator = $this->validator($params);
        if ($validator->passes()) {
            $params['secret'] = $params['password'];
            $params['password'] = Hash::make($params['password']);            
            try{
                $params['created_by'] = Auth::user()->id;
                $this->model->create($params);
                Session::flash('success','Successfully added.');
                return true;
            }
            catch (\Exception $e){
                Helper::log($e->getMessage());
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
        else{
            $error = Helper::errorToString($validator->errors()->all());
            Session::flash('error',$error);            
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
    
    public function getResellers(){
        $role = Role::where('slug','reseller')->first();
        if($role){
            $role_id = $role->id;
            $resellers = $this->model->where('role_id',$role_id)->get();
            return $resellers;
        }        
        return [];
    }    

    
    public function getResellerUsers($r_id){
        $role = Role::where('slug','customer')->first();
        $role_id = -1;
        if($role){$role_id= $role->id;}
        return $this->model->where(['reseller_id'=>$r_id,'role_id'=>$role_id])->get();
    }

    protected function validator(array $data, $update=false){
        if($update==false){
            return Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
                'role_id' => ['required', 'integer'],
                'phone' => ['required', 'string', 'max:11'],
                'address' => ['required', 'string', 'max:255'],
                'nid' => ['required', 'string', 'max:20'],
            ]);
        }
        else{
            return Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'role_id' => ['required', 'integer'],
                'phone' => ['required', 'string', 'max:11'],
                'address' => ['required', 'string', 'max:255'],
                'nid' => ['required', 'string', 'max:20'],
            ]);
        }
    }

}