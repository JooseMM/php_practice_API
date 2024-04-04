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
    /*
    $self = new self();
    $self->init_connection();
    $statement = <<<EOF
    DELETE FROM example WHERE id = "$target_id"; 
    EOF;
    $result = $self->query($statement);
    $self->close();
    return $result;
     */
    $sql = "DELETE FROM example "
      . "WHERE id = :target_id";

    $self = new self();
    $stmt = $self->PDO->prepare($sql);
    $stmt->bindValue(":target_id", $target_id);
    $stmt->execute();

    return $stmt->rowCount();
  }

}
//Testing!
//6605a317dbe3a

