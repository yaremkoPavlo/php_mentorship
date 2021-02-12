<?php

namespace App\SortAlgorithms;

interface ArraySortInterface
{
    /**
     * @param array $arr
     * @return array
     */
    public function sort(array $arr): array;
}
