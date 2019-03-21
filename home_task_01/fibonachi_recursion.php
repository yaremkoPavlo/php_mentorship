<?php

function fibonaci(int $n) {
	if ($n == 0)
		return 0;
	if ($n == 1)
		return 1;
	return (fibonaci($n-1) + fibonaci($n-2));
}

$i = fibonaci_optim(20);
//$i = fibonaci(40);
echo $i;

$mem = [];
function fibonaci_optim($n) {
	global $mem;
	if ($n == 0)
		return 0;
	if ($n == 1) 
		return 1;
	if ($mem[$n])
		return $mem[$n];
	else {
		$res = fibonaci_optim($n-1) + fibonaci_optim($n-2);
		$mem[$n] = $res;
		return $res;
	}
}

