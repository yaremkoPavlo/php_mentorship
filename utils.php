<?php

/**
 * @param array $arr
 */
function echoArray($arr)
{
    if (!is_array($arr)) {
        throw new \InvalidArgumentException();
    }

    echo ('[' . implode(', ', $arr) . ']' . PHP_EOL);
}
