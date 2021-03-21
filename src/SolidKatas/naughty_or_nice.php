<?php

function what_list_am_i_on(array $actions): string
{
    $naughty_count = 0;
    $nice_count = 0;

    $naughty_letters = ['b', 'f', 'k'];
    $nice_letters = ['g', 's', 'n'];

    foreach ($actions as $action) {
        if (in_array($action[0], $naughty_letters)) {
            $naughty_count++;
            continue;
        }

        if (in_array($action[0], $nice_letters)) {
            $nice_count++;
            continue;
        }
    }

    return $naughty_count >= $nice_count ? 'naughty' : 'nice';
}
