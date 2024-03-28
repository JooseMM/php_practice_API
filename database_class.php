<?php

class MyDatabase extends SQLite3 
{
  function __construct() {}

  function init_connection()
  {
    $this->open('./sqlite_database/example.db');
  }

  function get_all()
  {
    $this->init_connection();

    $sql_query = "SELECT * FROM example;";
    $query_outcome = $this->query($sql_query);
    while($row = $query_outcome->fetchArray(SQLITE3_ASSOC)) 
    {
      echo "ID = ". $row['id'] . "\n";
      echo "NAME = ". $row['name'] ."\n";
      echo "ADDRESS = ". $row['age'] ."\n";
    }
    $this->close();
  }

  function add_person($name, $age)
  {

    $this->init_connection();

    $new_person = $this->clean_data($name, $age);
    var_dump($new_person);
   $sql_exec = <<<EOF
      INSERT INTO example VALUES(6, "{$new_person['name']}", {$new_person['age']}); 
    EOF;
    $outcome = $this->exec($sql_exec);

    $this->close();
  }

  function clean_data($name, $age)
  {
    return ["name" => $name, "age" => $age];
    //TODO: clear incoming data
  }

}
  $database = new MyDatabase();
  $database->add_person('Americo Vespucio', 200);
  $database->get_all();
