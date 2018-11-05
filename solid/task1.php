<?php
//Single responsibility 

class Report 
{
   public function between($start, $end, iFormat $formatMethod) 
    {
       $result = $this->queryDbBetween($start, $end);
       return $formatMethod::format($result);
   }
    public  function queryDbBetween($start, $end)
    {
        $data = DB::query(
            "SELECT SUM(value) FROM table WHERE value BETWEEN ".
            $start ." AND ". $end
        );

        return $data;
    }
}

class FormatingReport implements iFormat
{
   public static function format($value) {
       return node_format($value, 0, ",");
   }
}

interface iFormat
{
	public static function format($value);
}
?>