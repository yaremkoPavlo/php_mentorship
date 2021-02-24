<?php

interface CanFly
{
    public function fly();
}

interface CanSwim
{
    public function swim();
}

interface CanClimb
{
    public function climb();
}

interface CanGreet
{
    public function greet($name);
}

interface CanIntroduce
{
    public function speak();
    public function introduce();
}

interface CanSpeak
{
    public function speak();
}

class Bird implements CanFly
{
    public $name;

    public function __construct($name)
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException('The argument should ideally be a string');
        }
        $this->name = $name;
    }

    public function fly()
    {
        return "I am flying";
    }

    public function chirp()
    {
        return "Chirp chirp";
    }
}

class Duck extends Bird implements CanFly, CanSwim
{
    public function chirp()
    {
        return "Quack quack";
    }

    public function swim()
    {
        return "Splash! I'm swimming";
    }
}

class Cat implements CanClimb
{
    public function climb()
    {
        return "Look, I'm climbing a tree";
    }

    public function meow()
    {
        return "Meow meow";
    }

    public function play($name)
    {
        return sprintf("Hey %s, let's play!", $name);
    }
}

class Dog implements CanSwim, CanGreet
{
    public function swim()
    {
        return "I'm swimming, woof woof";
    }

    public function greet($name)
    {
        return sprintf("Hello %s, welcome to my home", $name);
    }

    public function bark()
    {
        return "Woof woof";
    }
}

class Person implements CanGreet, CanIntroduce
{
    public $name;

    public $age;

    public $occupation;

    public function __construct($name, $age, $occupation)
    {
        $this->name = $name;
        $this->age = $age;
        $this->occupation = $occupation;
    }

    public function greet($name)
    {
        return sprintf("Hello %s, how are you?", $name);
    }

    public function speak()
    {
        return "What am I supposed to say again?";
    }

    public function introduce()
    {
        return sprintf("Hello, my name is %s, I am %d years old and I am currently working as a(n) %s", $this->name, $this->age, $this->occupation);
    }
}
