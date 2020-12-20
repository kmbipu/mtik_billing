<?php

namespace App\Services;
use Session;
use Auth;
use Exception;
use Illuminate\Support\Facades\Hash;

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
    
    
    public static function changePassword($current_password, $new_password, $confirm_password) {
        try{
            $user = Auth::user();
           
            if(!Hash::check($current_password, $user->password)){
                Session::flash('error','Current password dosent match.');
                return false;
            }
            
            if(strcmp($new_password,$confirm_password)!=0){
                Session::flash('error','New and confirm password dosent match.');
                return false;
            }
            
            $hash_password = Hash::make($new_password);
            $user->update(['password'=>$hash_password,'secret'=>$new_password]);
            Session::flash('success','Successfully updated.');
            return true;
        }
        catch(\Exception $e){
            Helper::log($e->getMessage());
            Session::flash('error','Unable to update password.');
            return false;
        }
            
    }
    
}