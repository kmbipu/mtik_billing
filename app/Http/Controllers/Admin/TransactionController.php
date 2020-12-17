<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TransactionService;
use App\Services\UserService;

class TransactionController extends Controller
{
    private $service;
    
    public function __construct()
    {
        $this->service = new TransactionService();
    }
    
    public function index(){
        $args = $this->filter();
        $query = request('query');
        $data = $this->service->search($args, $query);
        $resellers = (new UserService())->getResellers();
        return view('admin.transaction.index', array('data'=>$data,'resellers'=>$resellers));
    }
    
    public function edit(Request $request, $id){
        if($request->method()=='POST'){
            $this->service->update(['id'=>$id], $this->filter($request->all()));
            return back();
        }
        $data = $this->service->find($id);
        if($data)
            return view('admin.transaction.edit',['data'=>$data]);
        else
            abort(404, "Not found");
    }
    
    public function delete($id){
       // $this->service->delete($id);
        return back();
    }
}
