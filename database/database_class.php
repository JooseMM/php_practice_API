<?php

class MyDatabase extends SQLite3 
{

  function __construct() {}

  private function init_connection()
  {
    $this->open('./database/example.db');
  }

  public static function get_all()
  {
    $instance = new self();
    $instance->init_connection();
    $sql_query = "SELECT * FROM example;";
    $query_outcome = $instance->query($sql_query);
    $data_array = [];
    
    if($query_outcome)
    {
	while($row = $query_outcome->fetchArray(SQLITE3_ASSOC)) 
	{
	  array_push($data_array, $row);
	}
    }

    $instance->close();
    return $data_array;
  }

  public static function add_person($name, $age)
  {
    $instance = new self();
    $instance->init_connection();
    $new_person = $instance->clean_data($name, $age);
    $new_id = uniqid();

    $sql_exec = <<<EOF
    INSERT INTO example VALUES("$new_id", "{$new_person['name']}", {$new_person['age']});
    EOF;

    $outcome = $instance->exec($sql_exec);
    $instance->close();
    return $outcome;
  }

  private function clean_data($name, $age)
  {
    return ["name" => $name, "age" => $age];
    //TODO: clear incoming data
  }

}

//Testing!
/*
MyDatabase::add_person('Jose Moreno', 25);
var_dump(MyDatabase::get_all());
*/

