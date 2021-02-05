<?php

namespace App\SortAlgorithms;

class MergeSort
{
    public function __construct()
    {
    }

    /**
     * @param array $arr
     * 
     * @return array
     */
    public function mergeSort(array $arr): array
    {
        $n = count($arr);

        if ($n < 2)
            return $arr;

        $arr = array_values($arr);
        $mid = floor($n / 2);

        $leftArray = array_slice($arr, 0, $mid);
        $rightArray = array_slice($arr, $mid);

        $leftArray = $this->mergeSort($leftArray);
        $rightArray = $this->mergeSort($rightArray);

        return $this->merge($leftArray, $rightArray);
    }

    /**
     * @param array $leftArray
     * @param array $rightArray
     * 
     * @return array
     */
    private function merge(array $leftArray, array $rightArray): array
    {
        $arr = [];
        $ni = count($leftArray);
        $nj = count($rightArray);
        // keyholder for leftArray
        $i = 0;
        // keyholder for rightArray
        $j = 0;
        // keyholder for resultArray
        $k = 0;
        while ($i < $ni && $j < $nj) {
            if ($leftArray[$i] < $rightArray[$j]) {
                $arr[$k] = $leftArray[$i];
                $i++;
            } else {
                $arr[$k] = $rightArray[$j];
                $j++;
            }
            $k++;
        }
        while ($i < $ni) {
            $arr[$k] = $leftArray[$i];
            $i++;
            $k++;
        }
        while ($j < $nj) {
            $arr[$k] = $rightArray[$j];
            $j++;
            $k++;
        }

        return $arr;
    }
}
