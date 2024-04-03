<?php
include './database/database_class.php';
include './data_transmission_tools/data_tools.php';

class GetController 
{

  public static function get_all()
  {
    $response = MyDatabase::get_all();
    Response::send_json(true, $response, NULL);
  }
  public static function get($query_string)
  {
    if(!DataValidation::not_empty_string($query_string)) 
    { 
      return Response::send_json(false, NULL, "Bad string query");
    }

      $translated_query = Request::translate_query($query_string);
      $query_response = MyDatabase::get_person($translated_query['id']);
      Response::send_json(true, $query_response, "Data requested successfully");
  }

}

class PostController 
{
  public static function add($raw_input) 
  {
      if(!Request::is_valid_input($raw_input))
      {
	return Response::send_json(false, NULL, "Invalid form data"); 
      }

      $is_successful = MyDatabase::add_person($raw_input);

      if(!$is_successful)
      {
	return Response::send_json(false, NULL, "Error while trying to add data to database");
      }
	return Response::send_json(true, NULL, "Data added successfully");

  }
}
