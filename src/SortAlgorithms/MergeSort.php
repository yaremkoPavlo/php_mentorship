<?php

namespace App\SortAlgorithms;

class MergeSort
{
    /**
     * @param array $array
     * 
     * @return array
     */
    public function mergeSort(array $arr): array
    {
        $arrCount = count($arr);

        if ($arrCount < 2)
            return $arr;

        $arr = array_values($arr);
        $middleIndex = floor($arrCount / 2);

        $leftArray = array_slice($arr, 0, $middleIndex);
        $rightArray = array_slice($arr, $middleIndex);

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
        $result = [];
        $leftArrayCount = count($leftArray);
        $rightArrayCount = count($rightArray);
        // index holder for $leftArray
        $iLeft = 0;
        // index holder for $rightArray
        $iRight = 0;
        // index holder for $result
        $iResult = 0;
        while ($iLeft < $leftArrayCount && $iRight < $rightArrayCount) {
            if ($leftArray[$iLeft] < $rightArray[$iRight]) {
                $result[$iResult] = $leftArray[$iLeft];
                $iLeft++;
            } else {
                $result[$iResult] = $rightArray[$iRight];
                $iRight++;
            }
            $iResult++;
        }
        while ($iLeft < $leftArrayCount) {
            $result[$iResult] = $leftArray[$iLeft];
            $iLeft++;
            $iResult++;
        }
        while ($iRight < $rightArrayCount) {
            $result[$iResult] = $rightArray[$iRight];
            $iRight++;
            $iResult++;
        }

        return $result;
    }
}
