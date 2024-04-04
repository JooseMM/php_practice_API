<?php
include './database/database_class.php';
include './data_handling/data_tools.php';

class GetController 
{

  public static function get_all()
  {
    $response = MyDatabase::get_all();
    Response::send_json(true, $response, NULL);
  }

  public static function get($raw_query)
  {
      $valid_query = Request::parse_query($raw_query);
      if(!$valid_query) { return Response::send_json(false, NULL, "Bad string query"); }
      if(!array_key_exists("id", $valid_query)) {  return Response::send_json(false, NULL, "Invalid id provided");   } 
      $database_response = MyDatabase::get_person($valid_query['id']);
      if(!$database_response) { return Response::send_json(true, NULL, "No match found"); }
      return Response::send_json(true, $database_response, "Data requested successfully");
  }

}

class PostController 
{
  public static function add($raw_input) 
  {
      if(!DataValidation::is_valid_input($raw_input))
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
