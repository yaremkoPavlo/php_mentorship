<?php
class Person
{
    protected $name;

    protected $age;

    protected $occupation;

    public function __construct($name, $age, $occupation)
    {
        $this->isValidName($name);
        $this->isValidAge($age);
        $this->isValidOccupation($occupation);
        $this->name = $name;
        $this->age = $age;
        $this->occupation = $occupation;
    }

    private function isValidOccupation($occupation)
    {
        if (!is_string($occupation)) {
            throw new InvalidArgumentException("Age must be a non-negative integer!");
        }
    }

    private function isValidAge($age)
    {
        if (!is_int($age) || $age < 0) {
            throw new InvalidArgumentException("Age must be a non-negative integer!");
        }
    }

    private function isValidName($name)
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException("Name must be a string!");
        }
    }

    public function get_name()
    {
        return $this->name;
    }

    public function get_age()
    {
        return $this->age;
    }

    public function get_occupation()
    {
        return $this->occupation;
    }

    public function set_name($name)
    {
        $this->isValidName($name);
        $this->name = $name;
    }

    public function set_age($age)
    {
        $this->isValidAge($age);
        $this->age = $age;
    }

    public function set_occupation($occupation)
    {
        $this->isValidOccupation($occupation);
        $this->occupation = $occupation;
    }
}
