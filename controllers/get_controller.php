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
  }
  public static function get($query_string)
  {
      //TODO: create a regex to recognize multiple values
      //with their respective names
  }

 
}
