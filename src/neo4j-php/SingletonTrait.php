<?php

namespace Liushuangxi\Neo4j;

/**
 * Trait SingletonTrait
 *
 * @package Liushuangxi\Neo4j
 */
trait SingletonTrait
{
    /**
     * @var null
     */
    protected static $instance = null;

    /**
     * SingletonTrait constructor.
     */
    private function __construct()
    {
    }

    /**
     * @return null
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}