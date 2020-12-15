<?php

namespace App\Services;

use App\Models\Pool;
use Illuminate\Support\Facades\Validator;
use App\Services\Helper;
use Session;
use Exception;

use Illuminate\Support\Facades\DB;

class PoolService
{
    private $model;

    public function __construct()
    {
        $this->model = new Pool();
    }

    public static function find($id){
        return Pool::find($id);
    }

    public static function getAll(){
        return Pool::get();
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

                $p2s = new Pear2Service($params['router_id']);
                $p2s->addPool($params['name'],$params['ip_range']);

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
            DB::beginTransaction();
            $pool = $this->model->find($id);
            $pool->delete();

            $p2s = new Pear2Service($pool['router_id']);
            $p2s->deletePool($pool->name);

            DB::commit();
            Session::flash('success','Successfully deleted.');
            return true;
        }
        catch (Exception $e){
            DB::rollBack();
            Session::flash('error', 'Unable to delete.');
            return false;
        }
    }

    protected function validator(array $data){
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'ip_range' => ['required', 'string', 'max:100'],
            'router_id' => ['required', 'integer', 'max:11'],
        ]);
    }

}