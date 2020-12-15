<?php

namespace App\Services;
use Session;
use Auth;
use Exception;

class AuthService
{
    public static function login($params){
        if(!isset($params['username']) || !isset($params['password']) || empty($params['username']) || empty($params['password'])){
            Session::flash('error','Username or Password is empty');
            return false;
        }
        $credentials = array(
            'username'=>$params['username'],
            'password'=>$params['password'],
            'active_status'=> 1
        );
        $remember = false;
        if(isset($params['remember']))
            $remember = $params['remember'];

        if(Auth::attempt($credentials, $remember)){
            Session::flash('success','Successfully logged in');
            return true;
        }
        else{
            Session::flash('error','Invalid login credentials');
            return false;
        }
    }
}