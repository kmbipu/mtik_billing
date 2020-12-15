<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RouterService;

class RouterController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new RouterService();
    }

    public function index(){
        $args = $this->filter();
        $query = request('query');
        $routers = $this->service->search($args,$query,true);
        return view('admin.router.index', array('routers'=>$routers));
    }

    public function add(Request $request){
        if($request->method()=='POST'){
            if($this->service->insert($request->all()))
                return back();            
        }    
        return view('admin.router.add');
    }

    public function edit(Request $request, $id){
        if($request->method()=='POST'){
            $this->service->update(['id'=>$id], $this->filter($request->all()));
            return back();
        } 
        $router = $this->service->find($id);
        if($router)     
            return view('admin.router.edit', array('router'=>$router));
        else
            abort(404, "Not found");
    }
    
    public function delete($id){
        $this->service->delete($id);
        return back();
    }

}
