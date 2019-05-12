<?php
require_once dirname(__DIR__) . "/vendor/autoload.php";

use Liushuangxi\Neo4j\Client;

error_reporting(E_ALL);
ini_set('display_errors', 1);

$client = Client::getInstance([
    'hostname' => 'localhost',
    'port'     => '7474',
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