<?php

namespace App\Services;

use App\Models\Role;
use Session;

class RoleService
{

    public static function find($id){
        return Role::find($id);
    }

    public static function search($params=[], $str="", $is_paginate = false, $rows = 15){
        $role = Role::where($params);
        if(!empty($str)){
            $user = $role->where(function($query) use ($str) {
                $query->orWhere('name','like',$str.'%');
            });
        }
        if($is_paginate)
            $roles = $role->paginate($rows);
        else
            $roles = $role->get();

        return $roles;
    }

    public static function insert($params){
        try{
            $rm = new Role();
            $rm->create($params);
            Session::flash('success','Successfully added.');
            return true;
        }
        catch (Exception $e){
            Session::flash('error',$e->getMessage());
            return false;
        }
    }

    public static function update($condition, $params){
        try{
            $rm = new Role();
            $rm->where($condition)->update($params);
            Session::flash('success','Successfully updated.');
            return true;
        }
        catch (Exception $e){
            Session::flash('error',$e->getMessage());
            return false;
        }
    }

    public static function delete($id){
        try{
            $rm = new Role();
            $rm->find($id)->delete();
            Session::flash('success','Successfully deleted.');
            return true;
        }
        catch (Exception $e){
            Session::flash('error',$e->getMessage());
            return false;
        }
    }



}