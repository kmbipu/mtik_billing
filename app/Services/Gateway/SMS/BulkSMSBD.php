<?php 
namespace App\Services\Gateway\SMS;

class BulkSMSBD
{
    private $user_name = "pqsnetwork1";
    private $password = "92WKN6VG";
    private $url = "http://66.45.237.70/api.php";
    public $error = "";
    
    public function send($receiver,$message){
        $data= array(
            'username'=> $this->user_name,
            'password'=>$this->password,
            'number'=>$receiver,
            'message'=>$message
        );
        return $this->callApi($this->url,$data);
    }
    
    public function getBalance(){
        
    }
    
    public function callApi($url,$data){
        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);
        $p = explode("|",$smsresult);
        $sendstatus = $p[0];
        if($sendstatus=="1101")
            return true;
            else{
                $this->setError($sendstatus);
                return false;
            }
    }
    
    public function setError($code_id){
        $code = array(
            '1000'=>'Invalid user or password',
            '1002'=>'Empty Number',
            '1003'=>'Invalid message or empty message',
            '1004'=>'Invalid number',
            '1005'=>'All number is invalid',
            '1006'=>'Insufficient balance',
            '1009'=>'Inactive account',
            '1010'=>'Max number Limit exceeded'
        );
        $this->error = $code[$code_id];
    }
    
}