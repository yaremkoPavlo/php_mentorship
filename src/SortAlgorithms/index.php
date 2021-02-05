<?php

namespace App\SortAlgorithms;

require 'MergeSort.php';
require 'QuickSort.php';

$arr = [2, 4, 1, 6, 8, 5, 3, 7];

$q = new QuickSort();
$m = new MergeSort();

print_r($m->mergeSort($arr));
echo PHP_EOL;
print_r($q->quickSort($arr));
