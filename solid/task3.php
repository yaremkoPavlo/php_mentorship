<?php
//Liskov substitution

class Player
{
   public function play($file)
   {
       return readfile($file);
   }
}

class AviPlayer extends Player
{
   public function play($file)
   {
       return $this->checkAviExtension($file) ? readfile($file) : "Wrong file format";
   }
   
   protected function checkAviExtension($file)
   {
		return pathinfo($file, PATHINFO_EXTENSION) !== 'avi';
   }
}
?>
