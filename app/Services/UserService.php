<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Services\Helper;
use Session;

class UserService
{
    public static function find($id){
        return User::find($id);
    }

    public static function search($params=[], $str="", $is_paginate = false, $rows = 15){
        $user = User::where($params);
        if(!empty($str)){
            $user = $user->where(function($query) use ($str) {
                $query->orWhere('name','like',$str.'%');
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
            $params['password'] = Hash::make($params['password']);
            $params['secret'] = $params['password'];
            try{
                User::create($params);
                Session::flash('success','Successfully added.');
                return true;
            }
            catch (\Exception $e){
                Session::flash('error',$e->getMessage());
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
                User::where($condition)->update($params);
                Session::flash('success','Successfully updated.');
                return true;
            }
            catch (\Exception $e){
                Session::flash('error',$e->getMessage());
                return false;
            }
        }
        else{
            $error = Helper::errorToString($validator->errors()->all());
            Session::flash('error',$error);            
            return false;
        }
    }

    public static function delete($id){
        try{
            User::find($id)->delete();
            Session::flash('success','Successfully deleted.');
            return true;
        }
        catch (Exception $e){
            Session::flash('error',$e->getMessage());
            return false;
        }
    }

    protected function validator(array $data, $update=false){
        if($update==false){
            return Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
                'role_id' => ['required', 'integer', 'max:99'],
                'phone' => ['required', 'string', 'max:11'],
                'address' => ['required', 'string', 'max:255'],
                'nid' => ['required', 'string', 'max:20'],
            ]);
        }
        else{
            return Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'role_id' => ['required', 'integer', 'max:99'],
                'phone' => ['required', 'string', 'max:11'],
                'address' => ['required', 'string', 'max:255'],
                'nid' => ['required', 'string', 'max:20'],
            ]);
        }
    }

}