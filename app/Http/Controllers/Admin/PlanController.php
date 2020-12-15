<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PlanService;

class PlanController extends Controller
{
    private $service;
    
    public function __construct()
    {
        $this->service = new PlanService();
    }

    public function index(){      
        $args = $this->filter();
        $query = request('query');
        $data = $this->service->search($args, $query);
        return view('admin.plan.index', array('data'=>$data));
    }

    public function add(Request $request){
        if($request->method()=='POST'){
            if($this->service->insert($request->all()))
                return back();            
        } 
        return view('admin.plan.add');
    }

    public function edit(Request $request, $id){
        if($request->method()=='POST'){
            $this->service->update(['id'=>$id], $this->filter($request->all()));
            return back();
        } 
        $data = $this->service->find($id);
        if($data)     
            return view('admin.plan.edit', array('data'=>$data));
        else
            abort(404, "Not found");
    }
    
    public function delete($id){
        $this->service->delete($id);
        return back();
    }
}
