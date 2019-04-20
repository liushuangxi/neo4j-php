<?php

namespace Liushuangxi\Neo4j;

use Psr\Log\LoggerInterface;

/**
 * Class Logger
 *
 * @package Liushuangxi\Neo4j
 */
class Logger
{
    use SingletonTrait;

    /**
     * @var null
     */
    public $logger = null;

    /**
     * @param $logger
     */
    public static function setLogger($logger)
    {
        self::getInstance()->logger = $logger;
    }

    /**
     * @param $message
     */
    public static function logInfo($message)
    {
        if (!is_null(self::getInstance()->logger)) {
            self::getInstance()->logger->logInfo($message);
        }
    }

    /**
     * @param $message
     */
    public static function logError($message)
    {
        if (!is_null(self::getInstance()->logger)) {
            self::getInstance()->logger->logError($message);
        }
    }
}