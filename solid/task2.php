<?php
//Open closed prinsiple

class Square implements iCalcArea
{
   public $w;
   public $h;

   public function __construct($w, $h)
   {
       $this->w = $w;
       $this->h = $h;
   }
   
   public function calcArea()
   {
		return $this->w * $this->h;
   }
}

class AreaCalc
{
   public static function area(iCalcArea $shape)
   {
       return $shape->calcArea();
   }
}

class Circle implements iCalcArea
{
   public $r;
 
   public function __construct($r)
   {
       $this->r = $r;
   }
   
   public function calcArea()
   {
		return pow($this->r,2) * M_PI ;
   }
}

interface iCalcArea
{
    public function calcArea();
}
?>