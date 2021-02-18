<?php

abstract class Person
{
    public $name;

    public $age;

    public $gender;

    public function __construct($name, $age, $gender)
    {
        $this->name = $name;
        $this->age = $age;
        $this->gender = $gender;
    }

    abstract public function introduce();

    public function greet($name)
    {
        return sprintf("Hello %s", $name);
    }
}

final class Child extends Person
{
    public $aspirations;

    public function __construct($name, $age, $gender, $aspirations)
    {
        parent::__construct($name, $age, $gender);
        $this->aspirations = $aspirations;
    }

    public function introduce()
    {
        return sprintf("Hi, I'm %s and I am %d years old", $this->name, $this->age);
    }

    public function greet($name)
    {
        return sprintf("Hi %s, let's play!", $name);
    }

    public function say_dreams()
    {
        $aspirations = $this->say_list($this->aspirations);
        return sprintf("I would like to be a(n) %s when I grow up.", $aspirations);
    }

    private function say_list($list)
    {
        if (count($list) <= 1) {
            return implode('', $list);
        }

        $last_element = array_pop($list);

        return count($list) > 1 ? implode(', ', $list) . ' or ' .  $last_element : implode('', $list) . ' or ' .  $last_element;
    }
}

class ComputerProgrammer extends Person
{
    public $occupation;

    public function __construct($name, $age, $gender)
    {
        parent::__construct($name, $age, $gender);
        $this->occupation = "Computer Programmer";
    }

    public function introduce()
    {
        return sprintf("Hello, my name is %s, I am %d years old and I am a(n) %s", $this->name, $this->age, $this->occupation);
    }

    public function greet($name)
    {
        return sprintf("%s, I'm %s, nice to meet you", parent::greet($name), $this->name);
    }

    public function advertise()
    {
        return "Don't forget to check out my coding projects";
    }
}
