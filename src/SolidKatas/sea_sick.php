<?php

function sea_sick(string $s): string
{
  $wave_count = strlen($s);
  $wave_changed = 0;

  for ($i = 0; $i < $wave_count; $i++) {
    if ($i === 0) {
      continue;
    }

    if ($s[$i] !== $s[$i - 1]) {
      $wave_changed++;
    }
  }

  return $wave_changed / $wave_count < 0.2 ? 'No Problem' : 'Throw Up';
}
