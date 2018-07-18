<?php

require 'Tree.php';

$tree = new Tree();
$tree->createTable();

function createNodeChild($tree, $nodeParentId = 0, $nodeParentName = 'Раздел ', $level = 1) {
    if ($level > 4) {
        return;
    }
    $countNodes = rand(1, 5);
    for ($i = 1; $i <= $countNodes; $i ++) {
        $nodeId = $tree->addNode($nodeParentName.$i, $nodeParentId);
        if (rand(1, 3) >= 2) {
            createNodeChild($tree, $nodeId, $nodeParentName.$i.'.', $level+1);
        }
    }
}
createNodeChild($tree);