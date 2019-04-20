<?php

namespace Liushuangxi\Neo4j;

/**
 * Class Client
 *
 * @package Liushuangxi\Neo4j
 */
class Client
{
    /**
     * @var \Everyman\Neo4j\Client|null
     */
    private static $client = null;

    /**
     * Client constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param array $config
     *  hostname
     *  port
     *  username
     *  password
     *  logger
     *
     * @return \Everyman\Neo4j\Client|null
     */
    public static function getInstance($config = [])
    {
        if (!is_null(self::$client)) {
            return self::$client;
        }

        if (isset($config['logger'])) {
            Logger::setLogger($config['logger']);
        }

        try {
            if (!isset($config['hostname']) || empty($config['hostname'])) {
                Logger::logInfo(__CLASS__ . ' ' . __FUNCTION__ . ' hostname is empty');
                return null;
            }
            if (!isset($config['port']) || empty($config['port'])) {
                Logger::logInfo(__CLASS__ . ' ' . __FUNCTION__ . ' port is empty');
                return null;
            }

            self::$client = new \Everyman\Neo4j\Client($config['hostname'], $config['port']);

            if (isset($config['username']) && isset($config['password'])) {
                self::$client->getTransport()
                    ->setAuth($config['username'], $config['password']);
            }
        } catch (\Exception $e) {
            Logger::logError(__CLASS__ . ' ' . __FUNCTION__ . ' ' . $e->getMessage());
            return null;
        }

        return self::$client;
    }
}