<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function filter($params=false)
    {  
        if($params==false)
            $params = request()->all();
        unset($params['query']);
        unset($params['page']);
        unset($params['_token']);
        foreach ($params as $k => $v)
        {
            if(!isset($params[$k]))
                unset($params[$k]);
        }

        return $params;
    }

}
