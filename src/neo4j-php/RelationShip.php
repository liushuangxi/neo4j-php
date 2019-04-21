<?php

namespace Liushuangxi\Neo4j;

/**
 * Class RelationShip
 *
 * @package Liushuangxi\Neo4j
 */
class RelationShip extends Object
{
    use SingletonTrait;

    /**
     * @var string
     */
    public $objectType = Object::OBJECT_TYPE_RELATION_TYPE;

    /**
     * @var Node|null
     */
    private $node = null;

    /**
     * RelationShip constructor.
     */
    public function __construct()
    {
        $this->node = Node::getInstance();

        parent::__construct();
    }

    /**
     * @param array $info
     *  start_node
     *  start_node_id
     *  end_node
     *  end_node_id
     *  type
     *
     * @param array $properties
     *
     * @return bool|int
     */
    public function insert($info = [], $properties = [])
    {
        try {
            $startNode = null;
            $endNode   = null;
            $type      = $info['type'] ?? '';

            if (isset($info['start_node'])) {
                $startNode = $info['start_node'];
            } else if (isset($info['start_node_id'])) {
                $startNode = $this->node->get($info['start_node_id']);
            }
            if (empty($startNode)) {
                Logger::logInfo(__CLASS__ . ' ' . __FUNCTION__ . ' start_node/start_node_id is empty');
                return false;
            }

            if (isset($info['end_node'])) {
                $endNode = $info['end_node'];
            } else if (isset($info['end_node_id'])) {
                $endNode = $this->node->get($info['end_node_id']);
            }
            if (empty($endNode)) {
                Logger::logInfo(__CLASS__ . ' ' . __FUNCTION__ . ' end_node/end_node_id is empty');
                return false;
            }

            if (!isset($info['type'])) {
                Logger::logInfo(__CLASS__ . ' ' . __FUNCTION__ . ' type is empty');
                return false;
            }

            if (!empty($properties)) {
                $object = $this->queryOne($type, $properties);
                if (!empty($object)) {
                    return $object->getId();
                }
            }

            $object = $this->client->makeRelationship();
            $object->setStartNode($startNode)
                ->setEndNode($endNode)
                ->setType($type)
                ->setProperties($properties)
                ->save();

            return $object->getId();
        } catch (\Exception $e) {
            Logger::logError(__CLASS__ . ' ' . __FUNCTION__ . ' ' . $e->getMessage());

            return false;
        }
    }
}