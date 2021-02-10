<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SmsService;
use App\Services\SettingService;

class SmsController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new SmsService();
    }

    public function list(){
        $args = $this->filter();
        $query = request('query');
        $data = $this->service->search($args, $query, true);
        return view('admin.sms.list', array('data'=>$data));
    }


    public function send(Request $request) {
        if($request->method()=='POST'){
            $single_group = $request->single_group;
            if($single_group=='single'){
                $this->service->sendSingle($request->phone, $request->message);
            }
            else if($single_group=='group'){
                $this->service->sendGroup($request->group, $request->message);
            }
        }
        $saved_message = SettingService::find('saved_message');
        $data = null;
        if($saved_message){
            $data = json_decode($saved_message,true);
        }
        return view('admin.sms.send',array('data'=>$data));
    }

    public function setting(Request $request) {
        if($request->method()=='POST'){
            $action = $request->action;
            if($action=='save_setting') {
                $json = json_encode($this->filter());
                SettingService::save('sms', $json);
            }
            else if($action=='save_message') {
                $f = $this->filter();
                unset($f['action']);
                $json = json_encode($f);
                SettingService::save('saved_message', $json);
            }
            return back();
        }

        $data = array(
            'before_expire' => '',
            'before_expire_message' => '',
            'recharge_message' => '',
            'suspend_message' => '',
            'status' => '0',
            'message_one' => '',
            'message_two' => '',
            'message_three' => '',
        );

        $setting = SettingService::find('sms');
        if($setting){
            $data = array_merge($data,json_decode($setting,true));
        }
        $saved_message = SettingService::find('saved_message');

        if($saved_message){
            $data = array_merge($data,json_decode($saved_message,true));
        }

        return view('admin.sms.setting',$data);
    }

}
