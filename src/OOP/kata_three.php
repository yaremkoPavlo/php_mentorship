<?php

class CurrentUSPresident
{
    const name = "Barack Obama";

    public static function greet($name)
    {
        return "Hello $name, my name is Barack Obama, nice to meet you!";
    }
}

$president_name = CurrentUSPresident::name;

$greetings_from_president = CurrentUSPresident::greet("Donald");
