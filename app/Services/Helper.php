<?php

namespace App\Services;
use Illuminate\Support\Facades\Log;

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
}