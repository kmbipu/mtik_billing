<?php

namespace App\Services;

use App\Models\Role;
use Session;
use Exception;

class RoleService
{

    private $model;

    public function __construct()
    {
        $this->model = new Role();
    }

    public static function find($id){
        return Role::find($id);
    }

    public static function getAll(){
        return Role::get();
    }

    public function search($params=[], $str="", $is_paginate = false, $rows = 15){
        $role = $this->model->where($params);
        if(!empty($str)){
            $role = $role->where(function($query) use ($str) {
                $query->orWhere('name','like',$str.'%');
            });
        }
        if($is_paginate)
            $roles = $role->paginate($rows);
        else
            $roles = $role->get();

        return $roles;
    }

    public function insert($params){
        try{
            $this->model->create($params);
            Session::flash('success','Successfully added.');
            return true;
        }
        catch (Exception $e){
            Helper::log($e->getMessage());
            Session::flash('error', "Unable to add.");
            return false;
        }
    }

    public function update($condition, $params){        
        try{
            $this->model->where($condition)->update($params);
            Session::flash('success','Successfully updated.');
            return true;
        }
        catch (Exception $e){
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



}