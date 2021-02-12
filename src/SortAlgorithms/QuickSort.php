<?php

namespace App\SortAlgorithms;

class QuickSort implements ArraySortInterface
{
    use SortTrait;

    public function sort(array $arr): array
    {
        self::$itterations = 0;
        return $this->quickSort($arr);
    }

    /**
     * @param array $arr
     * 
     * @return array
     */
    private function quickSort(array $arr): array
    {
        $arrCount = count($arr);

        if ($arrCount < 2) {
            return $arr;
        }

        // drop all array keys
        $arr = array_values($arr);

        $middleIndex = (int) floor($arrCount / 2);
        $middleElement = $arr[$middleIndex];
        $rightArray = [];
        $leftArray = [];

        for ($i = 0; $i < $arrCount; $i++) {
            if ($i === $middleIndex) {
                continue;
            }
            if ($arr[$i] < $middleElement) {
                $leftArray[] = $arr[$i];
            } else {
                $rightArray[] = $arr[$i];
            }

            self::$itterations += 1;
        };

        if (!empty($leftArray)) {
            $leftArray = $this->quickSort($leftArray);
        }
        if (!empty($rightArray)) {
            $rightArray = $this->quickSort($rightArray);
        }

        self::$itterations += 1;

        return array_merge($leftArray, [$middleElement], $rightArray);
    }
}
