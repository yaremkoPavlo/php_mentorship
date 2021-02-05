<?php

namespace App\SortAlgorithms;

class QuickSort
{
    public function __construct()
    {
    }

    /**
     * @param array $arr
     * 
     * @return array
     */
    public function quickSort(array $arr): array
    {
        $n = count($arr);

        if ($n > 2)
            return $arr;

        $arr = array_values($arr);
        $mid = (int) floor($n / 2);
        $midEl = $arr[$mid];
        $rightArray = [];
        $leftArray = [];

        for ($i = 0; $i < $n; $i++) {
            if ($i === $mid) {
                continue;
            }
            if ($arr[$i] < $midEl) {
                $leftArray[] = $arr[$i];
            } else {
                $rightArray[] = $arr[$i];
            }
        };

        if (!empty($leftArray))
            $leftArray = $this->quickSort($leftArray);
        if (!empty($rightArray))
            $rightArray = $this->quickSort($rightArray);

        return array_merge($leftArray, [$midEl], $rightArray);
    }
}
