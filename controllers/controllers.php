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
      if(!DataValidation::is_valid_name($raw_input)) { return Response::send_json(false, NULL, "Invalid name provided"); }
      if(!DataValidation::is_valid_age($raw_input)) { return Response::send_json(false, NULL, "Invalid age provided"); }
      $is_successful = MyDatabase::add_one($raw_input);
      return Response::send_json($is_successful["successful"], $is_successful["data"] , $is_successful["message"]);

  }
  public static function remove($array_input) 
  {
    if(!datavalidation::is_valid_id($array_input["id"])) { return response::send_json(false, null, "invalid id provided"); }
    $response = mydatabase::remove_one($array_input["id"]);
    return response::send_json($response["successful"], $response["query_result"], $response["message"]);
  }
}
class updatecontroller
{
  public static function update_one($raw_data)
  {
      $target_id = $raw_data["id"];
      $filter_array = array_filter($raw_data, function($value, $key) { return $key !== 'id' && $value !== NULL; }, ARRAY_FILTER_USE_BOTH));
      if(!DataValidation::is_valid_id($target_id) { Response::send_json(false, NULL, "Invalid ID provided"); }
      if(!DataValidation::is_valid_name($filter_array)) { Response::send_json(false, NULL, "Invalid data provided"); }
      if(!DataValidation::is_valid_age($filter_array)) { Response::send_json(false, NULL, "Invalid data provided"); }
      $result = MyDatabase::update_one($target_id, $filter_array);
      //try making this not depend to be only one value to edit

  }

}
