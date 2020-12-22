<?php

namespace App\Services;

use App\Models\Setting;
use App\Services\Helper;
use Session;
use Exception;

class SettingService
{

    public static function find($key){
        $s = Setting::where('key',$key)->first();
        return $s?$s->value:null;
    }

    public static function save($key,$value){
        $model = new Setting();
        $record = $model->where('key',$key)->first();
        if($record)
            $model->where('key',$key)->update(['value'=>$value]);
        else
            $model->create(['key'=>$key,'value'=>$value]);

        Session::flash('success','Successfully saved');  
        return true;
    }

}