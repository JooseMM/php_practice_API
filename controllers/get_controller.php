<?php
include './database/database_class.php';

class GetController extends MyDatabase 
{

  public static function get_all()
  {
    $query_response = MyDatabase::get_all();
    $response_to_json = json_encode($query_response);
    header('Content-Type: application/json');
    echo $response_to_json;
    /*
    foreach($query_response as $person)
    {
      echo $person['id'] . " " . $person['name'] . " " . $person['age'] . " " . "\n";
    } 
     */
  }
  public static function get()
  {
      //TODO: get by id function
  }

}
