<?php

namespace App\Services;

use App\Models\Router;
use Illuminate\Support\Facades\Validator;
use App\Services\Helper;
use Session;

class RouterService
{
    public static function find($id){
        return Router::find($id);
    }

    public static function search($params=[], $str="", $is_paginate = false, $rows = 15){
        $router = Router::where($params);
        if(!empty($str)){
            $user = $router->where(function($query) use ($str) {
                $query->orWhere('name','like',$str.'%');
            });
        }
        if($is_paginate)
            $routers = $router->paginate($rows);
        else
            $routers = $router->get();

        return $routers;
    }

    public function insert($params){
        $validator = $this->validator($params);
        if ($validator->passes()) {
            try{
                Router::create($params);
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
                Router::where($condition)->update($params);
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
            Router::find($id)->delete();
            Session::flash('success','Successfully deleted.');
            return true;
        }
        catch (Exception $e){
            Session::flash('error',$e->getMessage());
            return false;
        }
    }

    protected function validator(array $data){
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'ip' => ['required', 'string', 'max:30'],
            'username' => ['required', 'string', 'max:50'],
            'password' => ['required', 'string', 'min:6'],
        ]);
    }

}