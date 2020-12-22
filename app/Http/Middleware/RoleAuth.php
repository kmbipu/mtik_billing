<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Permission;
use App\Models\PermissionRole;
use Illuminate\Http\Request;
use Auth;

class RoleAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {        
        try {
            $user = Auth::user();
            if($user->role->slug=='admin')
                return $next($request);
                
            $req_name = $request->route()->getName();
            
            $role_id = $user->role_id;
            
            $permission = Permission::where('name', $req_name)->first();
            $permission_id = $permission->id;
            $permission_role = PermissionRole::where(['permission_id' => $permission_id, 'role_id' => $role_id])->first();
            if($permission_role)
                return $next($request);
            else
                return response('Unauthorized Action', 403);
                                
        }
        catch (\Exception $e){
            return response('Unauthorized Action', 403);
        }
    }
}
