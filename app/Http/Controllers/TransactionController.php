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
    
    public function list(Request $request){        
        $args = $this->filter();        
        $data = $this->service->custom_search($args, request('query'), request('start_date'), request('end_date'));
        return view('admin.transaction.list', $data);
    }
    
    
    public function edit(Request $request, $id){
        $data = $this->service->find($id);
        if($data==null)
            return back();
        
        if($request->method()=='POST'){
            $this->service->update(['id'=>$id], $this->filter($request->all()));
            return back();
        }
        return view('admin.transaction.edit',['data'=>$data]);
 
    }
    
    public function delete($id){
        $this->service->delete($id);
        return back();
    }
    
    public function transfer(Request $request) {
        if($request->method()=='POST'){
            $action = $request->action;
            
            if($action=='review'){
                $data = $this->service->prepareTransferReview();
                return view('admin.transaction.transfer_review',['data'=>$data]);
            }
            else if($action=='transfer'){
                $this->service->transfer($this->filter());
                return redirect('/admin/prepaids/transfer');
            }
        }
        
        $resellers = (new UserService())->getSellers(true);
        return view('admin.transaction.transfer', ['resellers'=>$resellers]);
    }
    
}
