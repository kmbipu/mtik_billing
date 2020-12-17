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
            $prefix = RoleService::find($user->role_id)->type;
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
    
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
    
}
