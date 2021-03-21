<?php

function shark(int $pontoonDistance, int $sharkDistance, int $youSpeed, int $sharkSpeed, bool $dolphin): string
{
    $sharkTimeToPontoon = $sharkDistance / $sharkSpeed;
    $youTimeToPontoon = $pontoonDistance / $youSpeed;

    if ($dolphin) {
        $sharkTimeToPontoon *= 2;
    }

    return $youTimeToPontoon < $sharkTimeToPontoon ? 'Alive!' : 'Shark Bait!';
}
