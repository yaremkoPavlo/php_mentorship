<?php
//Single responsibility 

class Report 
{
    public function between($start, $end, QuerySelect $q, iFormat $formatMethod) 
	{
       $result = $q->queryDbBetween($start, $end);
       return $formatMethod::format($result);
    }
}

abstract class QuerySelect
{
	$db = null;
	public function __constract(iDb $db)
	{
		$this->db = $db;
	}
	public function queryDbBetween($start, $end);
}

class QuerySelectMySql extends QuerySelect
{
	public function queryDbBetween($start, $end)
    {
        $data = $this->db::query(
            "SELECT SUM(value) FROM table WHERE value BETWEEN ".
            $start ." AND ". $end
        );

        return $data;
    }
}

class FormatingReport implements iFormat
{
   public static function format($value) 
   {
       return node_format($value, 0, ",");
   }
}

interface iFormat
{
	public static function format($value);
}

interface iDb
{
	public static function query($value);
}
?>