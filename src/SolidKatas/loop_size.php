<?php

function loop_size(Node $node): int
{
    $node_list = [$node];
    $next_node = $node->getNext();

    while (!in_array($next_node, $node_list, true)) {
        $node_list[] = $next_node;
        $next_node = $next_node->getNext();
    }

    $index = array_search($next_node, $node_list, true);

    return count($node_list) - $index;
}
