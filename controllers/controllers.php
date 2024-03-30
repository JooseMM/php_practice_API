<?php
include './database/database_class.php';
include './data_transmission_tools/data_tools.php';

class GetController 
{

  public static function get_all()
  {
    $response = MyDatabase::get_all();
    Response::send_json($response);
  }
  public static function get($raw_query_string)
  {
    if(!$raw_query_string) 
    { 
      Response::send_json(["response"=> "bad query"]); 
    }

      $translated_query = Request::translate_query($raw_query_string);
      $query_response = MyDatabase::get_person($translated_query['id']);
      Response::send_json($query_response);
  }

}

class PostController extends MyDatabase 
{
  //TODO: later I'm lazy
}
