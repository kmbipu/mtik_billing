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
    
    public function rechargeList(Request $request){
        $args = $this->filter();
        $query = request('query');
        $args['type'] = 'recharge';
        $data = $this->service->custom_search($request->start_date, $request->end_date, $request->seller_id, $request->query_str);
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
