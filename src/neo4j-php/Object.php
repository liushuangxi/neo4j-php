<?php

namespace Liushuangxi\Neo4j;

/**
 * Class Object
 *
 * @package Liushuangxi\Neo4j
 */
class Object
{
    use SingletonTrait;

    const OBJECT_TYPE_NODE = 'node';
    const OBJECT_TYPE_RELATION_TYPE = 'relation_ship';

    /**
     * @var \Everyman\Neo4j\Client|null
     */
    public $client = null;

    /**
     * @var string
     */
    public $objectType = '';

    /**
     * Object constructor.
     */
    public function __construct()
    {
        $this->client = Client::getInstance();
    }

    /**
     * @param $function
     * @param $arguments
     *
     * @return mixed|null
     */
    public static function __callStatic($function, $arguments)
    {
        try {
            return call_user_func_array(
                [
                    self::getInstance(),
                    $function,
                ],
                $arguments
            );
        } catch (\Exception $e) {
            Logger::logError(__CLASS__ . ' ' . __FUNCTION__ . ' ' . $e->getMessage());
            return null;
        }
    }

    /**
     * @param $id
     *
     * @return bool
     */
    public function delete($id)
    {
        try {
            $object = $this->get($id);
            if (empty($object)) {
                return false;
            }

            $object->delete();

            return true;
        } catch (\Exception $e) {
            Logger::logError(__CLASS__ . ' ' . __FUNCTION__ . ' ' . $e->getMessage());

            return false;
        }
    }

    /**
     * @param $id
     *
     * @return bool|\Everyman\Neo4j\Node|\Everyman\Neo4j\Relationship|null
     */
    public function get($id)
    {
        try {
            $object = null;
            switch ($this->objectType) {
                case self::OBJECT_TYPE_NODE:
                    $object = $this->client->getNode($id);
                    break;
                case self::OBJECT_TYPE_RELATION_TYPE:
                    $object = $this->client->getRelationship($id);
                    break;
            }

            if (empty($object)) {
                return false;
            }

            return $object;
        } catch (\Exception $e) {
            Logger::logError(__CLASS__ . ' ' . __FUNCTION__ . ' ' . $e->getMessage());

            return false;
        }
    }
}