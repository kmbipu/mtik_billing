<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PoolService;
use App\Services\RouterService;

class PoolController extends Controller
{

    private $service;
    
    public function __construct()
    {
        $this->service = new PoolService();
    }

    public function list(){      
        $args = $this->filter();
        $query = request('query');
        $data = $this->service->search($args, $query);
        return view('admin.pool.list', array('data'=>$data));
    }

    public function add(Request $request){
        if($request->method()=='POST'){
            if($this->service->insert($request->all()))
                return back();            
        } 
        $routers = RouterService::getAll();
        return view('admin.pool.add',['routers'=>$routers]);
    }

    public function edit(Request $request, $id){
        if($request->method()=='POST'){
            $this->service->update(['id'=>$id], $this->filter($request->all()));
            return back();
        } 
        $data = $this->service->find($id);
        $routers = RouterService::getAll();
        if($data)     
            return view('admin.pool.edit', array('data'=>$data,'routers'=>$routers));
        else
            abort(404, "Not found");
    }
    
    public function delete($id){
        $this->service->delete($id);
        return back();
    }
    
    public function getByRouter($router_id) {
        $pools = $this->service->search(['router_id'=>$router_id]);
        return $pools;
    }


}
