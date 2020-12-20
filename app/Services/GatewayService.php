<?php 

namespace App\Services;

use Exception;
use App\Services\Gateway\SMS\BulkSMSBD;


class GatewayService
{
    
    public $error;
    
    public function sendSMS($phone, $message) {
        $clinet = new BulkSMSBD();
        $result = $clinet->send($phone, $message);
        if($result==true){
            return true;          
        }
        else{
            $this->error = $clinet->error;
            return false;
        }
    }
}