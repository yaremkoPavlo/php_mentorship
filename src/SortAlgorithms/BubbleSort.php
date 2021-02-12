<?php

namespace App\SortAlgorithms;

class BubbleSort implements ArraySortInterface
{
    use SortTrait;

    /**
     * @param array $arr
     * @return array
     */
    public function sort(array $arr): array
    {
        self::$itterations = 0;
        return $this->bubbleSort($arr);
    }

    /**
     * @param array $arr
     * @return array
     */
    private function bubbleSort(array $arr): array
    {
        $arrCount = count($arr);
        $arrLenght = $arrCount;

        $isSwap = false;

        if ($arrCount < 2) {
            return $arr;
        }

        $arr = array_values($arr);

        self::$itterations += 1;

        for ($i = 0; $i < $arrCount; $i++) {
            for ($j = 0; $j < $arrLenght - 1; $j++) {
                if ($arr[$j] > $arr[$j + 1]) {
                    $this->swap($arr[$j], $arr[$j + 1]);
                    $isSwap = true;
                    self::$itterations += 1;
                }

                self::$itterations += 1;
            }
            // The biggest value of array is in the end, next time for loop needs less operation 
            $arrLenght -= 1;

            self::$itterations += 1;

            // If never swap the value in array, that array was sorted
            if (!$isSwap) {
                break;
            }

            $isSwap = false;
        }

        return $arr;
    }

    /**
     * @param mixed $a
     * @param mixed $b
     * @return void
     */
    private function swap(&$a, &$b): void
    {
        $temp = $a;
        $a = $b;
        $b = $temp;
    }
}
