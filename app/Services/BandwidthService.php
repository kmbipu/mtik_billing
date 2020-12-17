<?php

namespace App\Services;

use App\Models\Bandwidth;
use Illuminate\Support\Facades\Validator;
use App\Services\Helper;
use Session;
use Exception;

class BandwidthService
{


    private $model;

    public function __construct()
    {
        $this->model = new Bandwidth();
    }

    public static function find($id){
        return Bandwidth::find($id);
    }

    public static function getAll(){
        return Bandwidth::get();
    }

    public function search($params=[], $str="", $is_paginate = false, $rows = 15){
        $router = $this->model->where($params);
        if(!empty($str)){
            $router = $router->where(function($query) use ($str) {
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

    protected function validator(array $data){
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'rate_down' => ['required', 'integer'],
            'rate_down_unit' => ['required', 'string', 'max:5'],
            'rate_up' => ['required', 'integer'],
            'rate_up_unit' => ['required', 'string', 'max:5'],
        ]);
    }

}