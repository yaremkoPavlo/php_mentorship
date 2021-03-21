<?php

function planeSeat($a)
{
    $front_seats = ['Front', 'Middle', 'Back', 'Back'];
    $side_seats = ['Left' => 'ABC', 'Middle' => 'DEF', 'Right' => 'GHK'];

    $matches = [];
    $res = 'No Seat!!';

    if (preg_match('/^(\d{1,2})([ABCDEFGHK]{1})$/', $a, $matches) && $matches[1] >= 1 && $matches[1] <= 60) {
        $res = sprintf(
            '%s-%s',
            $front_seats[(int)floor($matches[1] / 20)],
            array_keys(array_filter($side_seats, function ($val) use ($matches) {
                return strstr($val, $matches[2]);
            }))[0]
        );
    }

    return $res;
}
