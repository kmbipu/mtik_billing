<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TransactionService;
use App\Services\UserService;
use App\Services\Helper;

class TransactionController extends Controller
{
    private $service;
    
    public function __construct()
    {
        $this->service = new TransactionService();
    }
    
    public function rechargeList(Request $request){
        $args = $this->filter();
        if($u=Helper::isReseller()){
            $args['seller_id'] = $u->id;
        }

        $args['type'] = 'recharge';
        $data = $this->service->custom_search($args);
        return view('admin.transaction.recharge_list', $data);
    }
    
    public function transferList(){
        $args = $this->filter();
        $query = request('query');
        $args['type'] = 'transfer';
        $data = $this->service->search($args, $query);
        return view('admin.transaction.transfer_list', array('data'=>$data));
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
        $this->service->delete($id);
        return back();
    }
}
