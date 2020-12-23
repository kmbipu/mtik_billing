<?php

namespace App\Services;
use Illuminate\Support\Facades\Log;
use Auth;

class Helper
{
    public static function errorToString($errors){
        $errors = json_encode($errors);
        $errors = json_decode($errors,true);
        $l = '';
        foreach ($errors as $e =>$v)
            $l .= '<li>'.$v.'</li>';
        $err = '<ul>'.$l.'</ul>';
        return $err;
    }
    
    public static function log($e){
        Log::error($e);
    }
    
    public static function isReseller(){
        $user = Auth::user();
        if($user->role->name=='reseller')
            return $user;
        else 
            return false;
    }
    
    public static function isCustomer(){
        $user = Auth::user();
        if($user->role->name=='customer')
            return $user;
            else
                return false;
    }
    
    public static function isAdmin(){
        $user = Auth::user();
        if($user->role->name=='admin')
            return $user;
            else
                return false;
    }
    
}