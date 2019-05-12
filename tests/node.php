<?php
require_once dirname(__DIR__) . "/tests/common.php";

use Liushuangxi\Neo4j\Node;

$nodeId = Node::getInstance()->insert(
    [
        'name' => 'nodeA',
    ],
    [
        'node',
    ]
);

var_dump($nodeId);

$nodeId = Node::getInstance()->insert(
    [
        'name' => 'nodeB',
    ],
    [
        'node',
    ]
);

var_dump($nodeId);

$node = Node::getInstance()->queryOne(
    'node',
    [
        'name' => 'nodeA'
    ]
);

print_r($node);

$node = Node::getInstance()->deleteOne(
    'node',
    [
        'name' => 'nodeA'
    ]
);

var_dump($node);