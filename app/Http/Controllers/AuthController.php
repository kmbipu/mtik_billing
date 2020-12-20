<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Services\RoleService;
use Auth;

class AuthController extends Controller
{

    private function isLogged()
    {
        if(Auth::check()){
            $user = Auth::user();
            $prefix = RoleService::find($user->role_id)->slug;
            return '/'.$prefix;
        }
        else{
            return false;
        }
    }



    public function login(Request $request){        
        
        if($request->method()=='POST'){ 
            AuthService::login($request->all());
        } 

        if($route = $this->isLogged())
            return redirect($route);

        return view('auth.login');
    }
    
    
    public function changePassword(Request $request) {
        if($request->method()=='POST'){            
            AuthService::changePassword($request->current_password, $request->new_password, $request->confirm_password);                  
            return back();
        } 
        return view('auth.change_password');
    }
    
    
    
    
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
    
}
