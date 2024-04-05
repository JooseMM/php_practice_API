<?php
include './database/database_class.php';
include './data_handling/data_tools.php';

class GetController 
{

  public static function get_all()
  {
    $response = MyDatabase::get_all();
    Response::send_json($response["successful"], $response["query_result"], $response["message"]);
  }

  public static function get($raw_query)
  {
      $valid_query = Request::parse_query($raw_query);
      if(!$valid_query) { return Response::send_json(false, NULL, "Bad string query"); }
      if(!array_key_exists("id", $valid_query)) {  return Response::send_json(false, NULL, "Invalid id provided");   } 
      $response = MyDatabase::get_one($valid_query['id']);
      return Response::send_json($response["successful"], $response["query_result"], $response["message"]); 
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

      $is_successful = MyDatabase::add_one($raw_input);

      if(!$is_successful)
      {
	return Response::send_json(false, NULL, "Error while trying to add data to database");
      }
	return Response::send_json(true, NULL, "Data added successfully");

  }
  public static function remove($array_input) 
  {
    if(!DataValidation::is_valid_id($array_input["id"])) { return Response::send_json(false, NULL, "Invalid id provided"); }
    $response = MyDatabase::remove_one($array_input["id"]);
    return Response::send_json($response["successful"], $response["query_result"], $response["message"]);
  }
}
