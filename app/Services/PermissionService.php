<?php

namespace App\Services;

use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\Role;
use Session;
use Route;
use Exception;

class PermissionService
{

    private $model;

    public function __construct()
    {
        $this->model = new Permission();
    }

    public static function getAll(){
        return Permission::get();
    }

    public function search($role_id=0){
        $permissions = self::getAll();
        $permission_roles = PermissionRole::where('role_id', $role_id)->get();
        $roles = Role::get();
        return array('roles'=>$roles,'permissions'=>$permissions,'permission_roles'=>$permission_roles);
    }

    public function refreshReload(){

        foreach (Route::getRoutes()->getRoutes() as $key => $route)
        {
            $name = $route->getName();
            if (strpos($name, 'ignition') === 0 || empty($name)){
                //Nothing to do
            }
            else{
                try{
                    $permission = new Permission();     
                    $permission->name = $name;
                    $permission->save();
                }
                catch(\Exception $e){
                    
                }
            }
        } 
    
    }

    public function deleteMultiple($ids){
        try{
            $this->model->whereIn('id',$ids)->delete();
            Session::flash('success','Successfully deleted.');
            return true;
        }
        catch (Exception $e){
            Session::flash('error', 'Unable to delete.');
            return false;
        }       
    }

    public function assignRole($role_id, $permission_ids=[]){
        if($role_id==null || empty($role_id)){
            Session::flash('error', 'Please select a role first from top.');
            return false;
        }
        try{
            PermissionRole::where('role_id',$role_id)->delete();
            foreach($permission_ids as $pid){
                PermissionRole::create(['permission_id'=>$pid,'role_id'=>$role_id]);
            }
            Session::flash('success','Successfully assigned to the role.');
            return true;
        }
        catch (Exception $e){
            Session::flash('error', 'Unable to assign role.');
            return false;
        }

    }

}