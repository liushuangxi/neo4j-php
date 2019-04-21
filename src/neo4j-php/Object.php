<?php

namespace Liushuangxi\Neo4j;

use Everyman\Neo4j\Cypher\Query;

/**
 * Class Object
 *
 * @package Liushuangxi\Neo4j
 */
class Object
{
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

    /**
     * @param string $group
     *  node:label
     *  relation_ship:type
     *
     * @param array  $params
     *
     * @return \Everyman\Neo4j\Query\ResultSet|mixed|null
     */
    public function queryOne($group = '', $params = [])
    {
        $where = "";
        if (!empty($params)) {
            $where .= "WHERE ";
            foreach ($params as $k => $v) {
                $where .= "o.$k = \"$v\" AND ";
            }
            $where = trim($where, 'AND ');
        }

        $queryString = "";
        switch ($this->objectType) {
            case self::OBJECT_TYPE_NODE:
                $queryString = "MATCH (o:$group) $where";
                break;
            case self::OBJECT_TYPE_RELATION_TYPE:
                $queryString = "MATCH ()-[o:$group]-() $where";
                break;
        }
        $queryString .= " RETURN o LIMIT 1";

        try {
            $query  = new Query($this->client, $queryString, []);
            $result = $query->getResultSet();
            if ($result->offsetExists(0)) {
                $result = $result->offsetGet(0);
                if ($result->offsetExists(0)) {
                    $result = $result->offsetGet(0);
                } else {
                    $result = null;
                }
            } else {
                $result = null;
            }

            return $result;
        } catch (\Exception $e) {
            Logger::logError(__CLASS__ . ' ' . __FUNCTION__ . ' ' . $e->getMessage());
            return null;
        }
    }
}