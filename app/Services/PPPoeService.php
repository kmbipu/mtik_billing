<?php

namespace App\Services;
use PEAR2\Net\RouterOS;
use Exception;

require_once 'PEAR2/Autoload.php';

class PPPoeService
{
    private $client;

    public function __construct($router_id)
    {
        $router = RouterService::find($router_id);
        $this->connect($router);
    }

    private function connect($router){   
        try {
            $this->client = new RouterOS\Client($router->ip, $router->username, $router->password);
        } catch (Exception $e) {
            throw new Exception('Unable to connect to the router.');
        }
    }

    public function addPool($name, $ip_range){
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
        try{
            $printRequest = new RouterOS\Request(
                '/ip pool print .proplist=name',
                RouterOS\Query::where('name', $name)
            );
            $poolName = $this->client->sendSync($printRequest)->getProperty('name');
            
            $setRequest = new RouterOS\Request('/ip/pool/set');

            $client = $this->client;
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
        try{
            $printRequest = new RouterOS\Request(
                '/ip pool print .proplist=name',
                RouterOS\Query::where('name', $name)
            );
            $poolName = $this->client->sendSync($printRequest)->getProperty('name');
            
            $removeRequest = new RouterOS\Request('/ip/pool/remove');
            $client = $this->client;
            $client($removeRequest
                ->setArgument('numbers', $poolName)
            );
        }
        catch (Exception $e) {
            throw new Exception('Unable to update pool.');
        }
    }
    
    public function addPPPoeUser($user,$pass,$plan) {
        try{
            $addRequest = new RouterOS\Request('/ppp/secret/add');
            $client->sendSync($addRequest
                ->setArgument('name', $user)
                ->setArgument('service', 'pppoe')
                ->setArgument('profile', $plan)
                ->setArgument('password', $pass)
                );
        }
        catch (Exception $e) {
            throw new Exception('Unable to add pppoe user in server.');
        }
    }
    
    public function deletePPPoeUser($user) {
        try{
            $printRequest = new RouterOS\Request(
                '/ppp secret print .proplist=name',
                RouterOS\Query::where('name', $user)
                );
            $userName = $this->client->sendSync($printRequest)->getProperty('name');
            $removeRequest = new RouterOS\Request('/ppp/secret/remove');
            $client = $this->client;
            $client($removeRequest->setArgument('numbers', $userName));
        }
        catch (Exception $e) {
            throw new Exception('Unable to delete pppoe user in server.');
        }
    }
    
    public function addProfile($name, $pool, $rate) {        
        
        try{
            $addRequest = new RouterOS\Request('/ppp/profile/add');
            $this->client->sendSync($addRequest
                ->setArgument('name', $name)
                ->setArgument('local-address', $pool)
                ->setArgument('remote-address', $pool)
                ->setArgument('rate-limit', $rate)
                );
        }
        catch (Exception $e) {
            throw new Exception('Unable to add profile in server.');
        }
    }
    
    public function editProfile($name, $pool, $rate) {        
        
        try{
            $printRequest = new RouterOS\Request(
                '/ppp profile print .proplist=name',
                RouterOS\Query::where('name', $name)
                );
            $profileName = $client->sendSync($printRequest)->getProperty('name');
            
            $setRequest = new RouterOS\Request('/ppp/profile/set');
            $client = $this->client;
            $client($setRequest
                ->setArgument('numbers', $profileName)
                ->setArgument('local-address', $pool)
                ->setArgument('remote-address', $pool)
                ->setArgument('rate-limit', $rate)
                );
        }
        catch (Exception $e) {
            throw new Exception('Unable to edit profile in server.');
        }
    }
    
    public function deleteProfile($name) {
        
        
        try{
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
            throw new Exception('Unable to delete pppoe user in server.');
        }
    }



}