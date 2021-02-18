<?php

class Person
{
    const species = "Homo Sapiens";

    public $name;

    public $age;

    public $occupation;

    public function __construct($name, $age, $occupation)
    {
        $this->name = $name;
        $this->age = $age;
        $this->occupation = $occupation;
    }

    public function introduce()
    {
        return sprintf("Hello, my name is %s", $this->name);
    }

    final public function describe_job()
    {
        return sprintf("I am currently working as a(n) %s", $this->occupation);
    }

    final public static function greet_extraterrestrials($species)
    {
        return sprintf("Welcome to Planet Earth %s!", $species);
    }
}

class ComputerProgrammer extends Person
{
    public function introduce()
    {
        return sprintf("Hello, my name is %s and I am a %s", $this->name, $this->occupation);
    }
}
