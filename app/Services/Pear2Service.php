<?php

namespace App\Services;
use PEAR2\Net\RouterOS;
use Exception;

require_once 'PEAR2/Autoload.php';

class Pear2Service
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
            die('Unable to connect to the router.');
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
            die('Unable to add pool.');
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
            die('Unable to update pool.');
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
            die('Unable to update pool.');
        }
    }



}