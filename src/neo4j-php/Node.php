<?php

namespace Liushuangxi\Neo4j;

/**
 * Class Node
 *
 * @package Liushuangxi\Neo4j
 */
class Node extends Object
{
    /**
     * @var string
     */
    public $objectType = Object::OBJECT_TYPE_NODE;

    /**
     * @param $properties
     * @param $labels
     *
     * @return bool|int
     */
    public function insert($properties, $labels)
    {
        try {
            $object = $this->client->makeNode();
            $object->setProperties($properties)->save();

            $labelObjects = [];
            foreach ($labels as $label) {
                $labelObjects[] = $this->client->makeLabel($label);
            }

            if (!empty($labelObjects)) {
                $object->addLabels($labelObjects);
            }

            return true;
        } catch (\Exception $e) {
            Logger::logError(__CLASS__ . ' ' . __FUNCTION__ . ' ' . $e->getMessage());

            return false;
        }
    }

    /**
     * @param       $id
     * @param array $updates
     * @param array $deletes
     *
     * @return bool
     */
    public function updateProperties($id, $updates = [], $deletes = [])
    {
        try {
            $object = $this->get($id);
            if (empty($object)) {
                return false;
            }

            if (!empty($deletes)) {
                foreach ($deletes as $delete) {
                    $object = $object->removeProperty($delete);
                }
            }

            if (!empty($updates)) {
                $object = $object->setProperties($updates);
            }

            $object->save();

            return true;
        } catch (\Exception $e) {
            Logger::logError(__CLASS__ . ' ' . __FUNCTION__ . ' ' . $e->getMessage());

            return false;
        }
    }

    /**
     * @param       $id
     * @param array $updates
     * @param array $deletes
     *
     * @return bool
     */
    public function updateLabels($id, $updates = [], $deletes = [])
    {
        try {
            $object = $this->get($id);
            if (empty($object)) {
                return false;
            }

            if (!empty($updates)) {
                $labelObjects = [];
                foreach ($updates as $update) {
                    $labelObjects[] = $this->client->makeLabel($update);
                }

                $object->addLabels($labelObjects);
            }

            if (!empty($deletes)) {
                $labelObjects = [];
                foreach ($deletes as $delete) {
                    $labelObjects[] = $this->client->makeLabel($delete);
                }

                $object->removeLabels($labelObjects);
            }

            return true;
        } catch (\Exception $e) {
            Logger::logError(__CLASS__ . ' ' . __FUNCTION__ . ' ' . $e->getMessage());

            return false;
        }
    }
}