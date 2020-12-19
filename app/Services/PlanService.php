<?php

namespace App\Services;

use App\Models\Plan;
use Illuminate\Support\Facades\Validator;
use App\Services\Helper;
use Session;
use Exception;
use Illuminate\Support\Facades\DB;


class PlanService
{


    private $model;

    public function __construct()
    {
        $this->model = new Plan();
    }

    public static function find($id){
        return Plan::find($id);
    }

    public static function getAll(){
        return Plan::get();
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
                DB::beginTransaction();
                
                $this->model->create($params);
                $pool_name = PoolService::find($params['pool_id'])->name;
                $plan_name = $params['name'];
                $bw = BandwidthService::find($params['bandwidth_id']);

                if($bw->rate_down_unit == 'Kbps'){ $unitdown = 'K'; }else{ $unitdown = 'M'; }
                if($bw->rate_up_unit == 'Kbps'){ $unitup = 'K'; }else{ $unitup = 'M'; }
                $rate = $bw->rate_up.$unitup."/".$bw->rate_down.$unitdown;
                $p2s = new Pear2Service($params['router_id']);
                $p2s->addProfile($plan_name,$pool_name,$rate);
                
                DB::commit();
                Session::flash('success','Successfully added.');
                return true;
            }
            catch (\Exception $e){
                DB::rollBack();
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
                DB::beginTransaction();
                
                $this->model->where($condition)->update($params);
                $pool_name = PoolService::find($params['pool_id'])->name;
                $plan_name = $params['name'];
                $bw = BandwidthService::find($params['bandwidth_id']);
                if($bw->rate_down_unit == 'Kbps'){ $unitdown = 'K'; }else{ $unitdown = 'M'; }
                if($bw->rate_up_unit == 'Kbps'){ $unitup = 'K'; }else{ $unitup = 'M'; }
                $rate = $bw->rate_up.$unitup."/".$bw->rate_down.$unitdown;
                $p2s = new Pear2Service($params['router_id']);
                $p2s->editProfile($plan_name,$pool_name,$rate);
                
                DB::commit();
                Session::flash('success','Successfully updated.');
                return true;
            }
            catch (\Exception $e){
                DB::rollBack();
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
            DB::beginTransaction();
            $plan = $this->model->find($id);
            
            $plan->delete();
            
            $p2s = new Pear2Service($plan->router_id);
            $p2s->deleteProfile($plan->name);           
            
            
            DB::commit();
            Session::flash('success','Successfully deleted.');
            return true;
        }
        catch (Exception $e){
            DB::rollBack();
            Helper::log($e->getMessage());
            Session::flash('error', 'Unable to delete.');
            return false;
        }
    }

    protected function validator(array $data, $update=false){
        if($update==false){
            return Validator::make($data, [
                'name' => ['required', 'string', 'max:100', 'unique:plans'],
                'router_id' => ['required', 'integer'],
                'pool_id' => ['required', 'integer'],
                'bandwidth_id' => ['required', 'integer'],
                'price' => ['required', 'integer'],
                'validity' => ['required', 'integer'],
                'validity_unit' => ['required', 'string', 'max:10'],
            ]);
        }
        else{
            return Validator::make($data, [
                'name' => ['required', 'string', 'max:100'],
                'router_id' => ['required', 'integer'],
                'pool_id' => ['required', 'integer'],
                'bandwidth_id' => ['required', 'integer'],
                'price' => ['required', 'integer'],
                'validity' => ['required', 'integer'],
                'validity_unit' => ['required', 'string', 'max:10'],
            ]);
        }
    }

}