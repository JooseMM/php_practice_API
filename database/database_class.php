<?php

class MyDatabase extends SQLite3 
{

  function __construct() {}

  private function init_connection()
  {
    $this->open("./database/example.db");
 //   $this->open('example.db');
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

  public static function get($id)
  {
    $self = new self();
    $self->init_connection();
    $statement = $self->prepare("SELECT * FROM example WHERE id = ? ");
    $statement->bindValue(1, $id, SQLITE3_TEXT);
    $query_outcome = $statement->execute();
    $raw_result = $query_outcome->fetchArray(SQLITE3_ASSOC);
    $self->close();
    return $raw_result;
   
  }
  public static function add_one($data)
  {
    $self = new self();
    $self->init_connection();
    $new_id = uniqid();

    $sql_exec = <<<EOF
    INSERT INTO example VALUES("$new_id", "{$data["name"]}", {$data["age"]});
    EOF;

    $outcome = $self->exec($sql_exec);
    $self->close();
    return $outcome;
  }
  public static function remove_one($target_id)
  {
    $self = new self();
    $self->init_connection();
    $statement = $self->prepare("DELETE FROM example WHERE id = :person_id");
    $statement->bindValue(':person_id', $target_id, SQLITE3_TEXT);
    $sql_result = $statement->execute();
    return $sql_result->numColumns();
    
  }
}


