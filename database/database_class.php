<?php

class MyDatabase 
{
  //property declaration
  public static $db_path = './database/example.db';

  public static function get_one($person_id)
  {
    try 
    {
      $pdo = new PDO("sqlite:" . self::$db_path);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $statement = $pdo->prepare("SELECT * FROM example WHERE id = :id ");
      $statement->bindValue(":id", $person_id, PDO::PARAM_STR);
      $statement->execute();
      $query_result = [];
      while($row = $statement->fetch(PDO::FETCH_ASSOC)) { $query_result[] = $row; }
      $successful = count($query_result) > 0 ? true : false;
      return [ "successful" => $successful, "query_result" => $query_result, "message" => $successful ? NULL : "Unable to retrive the data" ];
    }
    catch(PDOException $e) { return [ "successful" => false, "query_result" => NULL, "message" => "Connection failed: " . $e->getMessage() ]; }
  }

  public static function get_all()
  { 
    try {
      $pdo = new PDO("sqlite:" . self::$db_path);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $successful = $pdo->query('SELECT * FROM example');
      $pdo = NULL;
      $query_result = [];
      while($row = $successful->fetch(PDO::FETCH_ASSOC)) { $query_result[] = $row; }
      return [ "successful" => $successful ? true : false , "query_result" => $query_result, "message" => NULL ];
    }
    catch(PDOException $e) { return [ "successful" => false, "query_result" => NULL, "message" => "Connection failed: " . $e->getMessage() ]; }

  }

  public static function add_one($new_person)
  {
    $person_name = $new_person["name"];
    $person_age = $new_person["age"];
    $person_id = uniqid();
    try 
    {
      $pdo = new PDO("sqlite:" . self::$db_path);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $statement = $pdo->prepare("INSERT INTO example VALUES (:id, :name, :age)");
      $statement->bindValue(":id", $person_id, PDO::PARAM_STR);
      $statement->bindValue(":name", $person_name, PDO::PARAM_STR);
      $statement->bindValue(":age", $person_age, PDO::PARAM_INT);
      $successful = $statement->execute();
      $pdo = NULL;
      return [ "successful" => $successful, "query_result" => NULL, "message" => "Data added successfully" ];
    }
    catch(PDOException $e) { return [ "successful" => false, "query_result" => NULL, "message" => "Connection failed: " . $e->getMessage() ]; }
  }

  public static function remove_one($target_id)
  {
    try 
    {
      if( !(self::get_one($target_id))["successful"] ) { return [ "successful" => false, "query_result" => NULL, "message" => "No match found" ]; }

      $pdo = new PDO("sqlite:" . self::$db_path);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $statement = $pdo->prepare("DELETE FROM example WHERE id = :id");
      $statement->bindValue(":id", $target_id, PDO::PARAM_STR);
      $statement->execute();
      $pdo = NULL;
      return [ "successful" => true, "query_result" => NULL, "message" => "Data removed successfully" ];
    }
    catch(PDOException $e) { return [ "successful" => false, "query_result" => NULL, "message" => "Connection failed: " . $e->getMessage() ]; }
  }

  public static function edit_one($target_id, $updated_value)
  {
    
    $params_array = get_specific_params($updated_value);
    if(!$params_array) { return NULL; }

    try 
    {
      $pdo = new PDO("sqlite:" . self::$db_path);
      [ $key_column, $value_type ] = $params_array;

      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $statement = $pdo->prepare("UPDATE example SET $key_column = :new_value WHERE person_id = :id");
      $statement->bindValue(":new_value", $updated_value[$key_column], $value_type);
      $statement->bindValue(":id", $target_id, PDO::PARAM_STR);
      $pdo = NULL;
      return $statement->execute();
    }
    catch(PDOException $e) { return "Connection failed: " . $e->getMessage(); }
  }

}



