<?php
require_once dirname(__DIR__) . "/tests/common.php";

use Liushuangxi\Neo4j\Node;
use Liushuangxi\Neo4j\RelationShip;

$startNodeId = Node::getInstance()->insert(
    [
        'name' => 'nodeC',
    ],
    [
        'node',
    ]
);

$endNodeId = Node::getInstance()->insert(
    [
        'name' => 'nodeD',
    ],
    [
        'node',
    ]
);

$relationId = RelationShip::getInstance()->insert(
    [
        'start_node_id' => $startNodeId,
        'end_node_id'   => $endNodeId,
        'type'          => 'relation',
    ],
    [
        'relation_name' => 'name C&D',
    ]
);

$relation = RelationShip::getInstance()->queryOne(
    'relation',
    [
        'relation_name' => 'name C&D',
    ]
);

print_r($relation);
