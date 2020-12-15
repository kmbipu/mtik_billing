<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RouterService;

class RouterController extends Controller
{
    public function __construct()
    {
        $this->model = new RouterService();
    }

    public function index(){
        $args = $this->filter();
        $query = request('query');
        $routers = $this->model->search();
        return view('admin.router.index', array('routers'=>$routers));
    }

    public function add(Request $request){
        if($request->method()=='POST'){
            if($this->model->insert($request->all()))
                return back();            
        }    
        return view('admin.router.add');
    }

    public function edit(Request $request, $id){
        if($request->method()=='POST'){
            $this->model->update(['id'=>$id], $this->filter($request->all()));
            return back();
        } 
        $router = $this->model->find($id);
        if($router)     
            return view('admin.router.edit', array('router'=>$router));
        else
            abort(404, "Not found");
    }
    
    public function delete($id){
        $this->model->delete($id);
        return back();
    }

}
