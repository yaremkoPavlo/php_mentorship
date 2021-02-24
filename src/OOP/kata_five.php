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

    public function describe_job()
    {
        return sprintf("I am currently working as a(n) %s", $this->occupation);
    }

    public static function greet_extraterrestrials($species)
    {
        return sprintf("Welcome to Planet Earth %s!", $species);
    }
}

class Salesman extends Person
{
    public function __construct($name, $age)
    {
        parent::__construct($name, $age, "Salesman");
    }

    public function introduce()
    {
        return sprintf("%s, don't forget to check out my products!", parent::introduce());
    }
}

class ComputerProgrammer extends Person
{

    public function __construct($name, $age)
    {
        parent::__construct($name, $age, "Computer Programmer");
    }
    public function describe_job()
    {
        return sprintf("%s, don't forget to check out my Codewars account ;)", parent::describe_job());
    }
}

class WebDeveloper extends ComputerProgrammer
{
    public function __construct($name, $age)
    {
        parent::__construct($name, $age);
        $this->occupation = "Web Developer";
    }
    public function describe_job()
    {
        return sprintf("%s And don't forget to check on my website :D", parent::describe_job());
    }

    public function describe_website()
    {
        return "My professional world-class website is made from HTML, CSS, Javascript and PHP!";
    }
}
