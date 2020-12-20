<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SmsService;

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
        $data = $this->service->search($args, $query);
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
        return view('admin.sms.send');
    }
    
}
