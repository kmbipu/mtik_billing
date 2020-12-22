<?php

namespace App\Services;
use PEAR2\Net\RouterOS;
use Exception;

require_once 'PEAR2/Autoload.php';

class Pear2Service
{
    private $client;
    private $debug = true;

    public function __construct($router_id)
    {
        $router = RouterService::find($router_id);
        $this->connect($router);
    }

    private function connect($router){
        if($this->debug){return false;}
        
        try {
            $this->client = new RouterOS\Client($router->ip, $router->username, $router->password);
        } catch (Exception $e) {
            throw new Exception('Unable to connect to the router.');
        }
    }

    public function addPool($name, $ip_range){
        if($this->debug){return false;}
        try{
            $addRequest = new RouterOS\Request('/ip/pool/add');
            $this->client->sendSync($addRequest
                ->setArgument('name', $name)
                ->setArgument('ranges', $ip_range)
            );
        }
        catch (Exception $e) {
            throw new Exception('Unable to add pool.');
        }
    }

    public function editPool($name, $ip_range){
        if($this->debug){return false;}
        try{
            
            $client = $this->client;
            
            $printRequest = new RouterOS\Request(
                '/ip pool print .proplist=name',
                RouterOS\Query::where('name', $name)
            );
            $poolName = $this->client->sendSync($printRequest)->getProperty('name');
            
            $setRequest = new RouterOS\Request('/ip/pool/set');
            
            $client($setRequest
                ->setArgument('numbers', $poolName)
                ->setArgument('ranges', $ip_range)
            );
        }
        catch (Exception $e) {
            throw new Exception('Unable to update pool.');
        }
    }

    public function deletePool($name){
        if($this->debug){return false;}
        try{
            $client = $this->client;
            
            $printRequest = new RouterOS\Request(
                '/ip pool print .proplist=name',
                RouterOS\Query::where('name', $name)
            );
            $poolName = $this->client->sendSync($printRequest)->getProperty('name');
            
            $removeRequest = new RouterOS\Request('/ip/pool/remove');
            
            $client($removeRequest
                ->setArgument('numbers', $poolName)
            );
        }
        catch (Exception $e) {
            throw new Exception('Unable to update pool.');
        }
    }
    
    public function addPPPoeUser($user,$pass,$plan) {
        if($this->debug){return false;}
        try{
            $addRequest = new RouterOS\Request('/ppp/secret/add');
            $this->client->sendSync($addRequest
                ->setArgument('name', $user)
                ->setArgument('service', 'pppoe')
                ->setArgument('profile', $plan)
                ->setArgument('password', $pass)
                );
        }
        catch (Exception $e) {
            Helper::log($e->getMessage());
            throw new Exception('Unable to add pppoe user in server.');
        }
    }
    
    public function deletePPPoeUser($user) {
        if($this->debug){return false;}
        try{
            $client = $this->client;
            $printRequest = new RouterOS\Request(
                '/ppp secret print .proplist=name',
                RouterOS\Query::where('name', $user)
                );
            $userName = $this->client->sendSync($printRequest)->getProperty('name');
            $removeRequest = new RouterOS\Request('/ppp/secret/remove');
            
            $client($removeRequest->setArgument('numbers', $userName));
        }
        catch (Exception $e) {
            throw new Exception('Unable to delete pppoe user in server.');
        }
    }
    
    public function addProfile($plan_name, $pool_name, $rate) {        
        if($this->debug){return false;}
        try{
            $addRequest = new RouterOS\Request('/ppp/profile/add');
            $this->client->sendSync($addRequest
                ->setArgument('name', $plan_name)
                ->setArgument('local-address', $pool_name)
                ->setArgument('remote-address', $pool_name)
                ->setArgument('rate-limit', $rate)
                );
        }
        catch (Exception $e) {
            throw new Exception('Unable to add profile in server.');
        }
    }
    
    public function editProfile($plan_name, $pool_name, $rate) {        
        if($this->debug){return false;}
        try{
            
            $client = $this->client;
            
            $printRequest = new RouterOS\Request(
                '/ppp profile print .proplist=name',
                RouterOS\Query::where('name', $plan_name)
                );
            $profileName = $client->sendSync($printRequest)->getProperty('name');
            
            $setRequest = new RouterOS\Request('/ppp/profile/set');
            
            
            $client($setRequest
                ->setArgument('numbers', $profileName)
                ->setArgument('local-address', $pool_name)
                ->setArgument('remote-address', $pool_name)
                ->setArgument('rate-limit', $rate)
                );
        }
        catch (Exception $e) {
            Helper::log($e->getMessage());
            throw new Exception('Unable to edit profile in server.');
        }
    }
    
    public function deleteProfile($name) {
        if($this->debug){return false;}
        
        try{
            
            $client = $this->client;
            $printRequest = new RouterOS\Request(
                '/ppp profile print .proplist=name',
                RouterOS\Query::where('name', $name)
                );
            $profileName = $client->sendSync($printRequest)->getProperty('name');
            
            $removeRequest = new RouterOS\Request('/ppp/profile/remove');
            $client($removeRequest
                ->setArgument('numbers', $profileName)
                );
        }
        catch (Exception $e) {
            Helper::log($e->getMessage());
            throw new Exception('Unable to delete pppoe user in server.');
        }
    }
    
    public function enablePPPoeUser($username){
        if($this->debug){return false;}
        try{
            $client = $this->client;
            $printRequest = new RouterOS\Request('/ppp/secret/print');
            $printRequest->setArgument('.proplist', '.id');
            $printRequest->setQuery(RouterOS\Query::where('name', $username));
            $id = $client->sendSync($printRequest)->getProperty('.id');
            
            $setRequest = new RouterOS\Request('/ppp/secret/enable');
            $setRequest->setArgument('numbers', $id);
            $client->sendSync($setRequest);
        }
        catch (Exception $e) {
            Helper::log($e->getMessage());
            throw new Exception('Unable to enable pppoe user in server.');
        }
    }
    
    public function disablePPPoeUser($username){
        if($this->debug){return false;}
        try{
            $client = $this->client;
            $printRequest = new RouterOS\Request('/ppp/secret/print');
            $printRequest->setArgument('.proplist', '.id');
            $printRequest->setQuery(RouterOS\Query::where('name', $username));
            $id = $client->sendSync($printRequest)->getProperty('.id');
            
            $setRequest = new RouterOS\Request('/ppp/secret/disable');
            $setRequest->setArgument('numbers', $id);
            $client->sendSync($setRequest);
        }
        catch (Exception $e) {
            Helper::log($e->getMessage());
            throw new Exception('Unable to disable pppoe user in server.');
        }
    }



}