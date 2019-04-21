<?php
require_once "./vendor/autoload.php";

error_reporting(-1);
ini_set('display_errors', 1);
//
$client = \Liushuangxi\Neo4j\Client::getInstance([
    'hostname' => 'localhost',
    'port'     => 7474,
    'username' => 'root',
    'password' => '891223',
    'logger'   => new class()
    {
        public function logInfo($message)
        {
            echo $message . "\n";
        }


        public function logError($message)
        {
            echo $message . "\n";
        }


    },
]);
//
//print_r($client->getServerInfo());
//
//
//exit;
//
//$data = \Liushuangxi\Neo4j\Node::getInstance()->insert(['a' => 'b'], ['mmm']);
//



$data = \Liushuangxi\Neo4j\RelationShip::getInstance()->insert(
    ['start_node_id'=>1100, 'end_node_id'=>1235, 'type'=> 'cc'],
    ['a' => 'b']);

var_dump($data);



//\Liushuangxi\Neo4j\Logger::logInfo(123);
