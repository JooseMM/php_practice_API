<?php

class Request
{
  public static function parse_query($query_string)
  {
    if(!DataValidation::validate_string_query($query_string))
    {
      return NULL;
    }

    $multiple_queries = str_contains($query_string, '&');
    $raw_array = $multiple_queries ? explode('&', $query_string) : $query_string; //separete values and keys from each other
    $final_array = [];

    if($multiple_queries)
    {
      for($i = 0; $i < count($raw_array); $i++)
      {
	$raw_array[$i] = explode('=', $raw_array[$i]); //separete values and keys 
	$final_array[$raw_array[$i][0]] = $raw_array[$i][0] == 'age' ? (int)$raw_array[$i][1] : $raw_array[$i][1]; // normalize keys and values into a new associative array
      }
      return $final_array;
    }

    $raw_array = explode('=', $raw_array); //separete values and keys 
    $final_array[$raw_array[0]] = $raw_array[0] == 'age' ? (int)$raw_array[1] : $raw_array[1]; // normalize keys and values into a new associative array
    
    return $final_array;
  }
  public static function get_specific_params($array)
  {
    switch(array_key_first($array))
    {
      case "name": return [ "name", PDO::PARAM_STR ]; break;
      case "age": return [ "age", PDO::PARAM_INT ]; break;
      default: return false; break;
    }
  }


}

class Response 
{

  public static function send_json($successful, $data, $message)
  { 
    $raw_response = [ "successful" => $successful, "data" => $data, "error"=> $successful ? false : true, "message"=> $message ];
    $parse_response = json_encode($raw_response);
    header('Content-Type: application/json');
    echo $parse_response;
  }

}

class DataValidation 
{

  public static function validate_string_query($raw_string_query)
  {
    $only_string_queries = "/^[a-zA-Z]+=[a-zA-Z0-9]+$/";

    if(!preg_match($only_string_queries, $raw_string_query)) { return false; }
    return true;
  }

  public static function is_valid_name($raw_data) 
  {
    $only_letters = "/^[a-zA-Z]+$/"; // Pattern to match only letters
    if(!preg_match($only_letters, $raw_data["name"])) { return false; } 
    return true;

  }
  public static function is_valid_age($raw_data) 
  {
    $only_age = "/^(?:[1-9]|[1-9][0-9]|1[0-4][0-9]|150)$/"; // Pattern to match numbers from 0 to 150
    if(!preg_match($only_age, $raw_data["age"])) { return false; } 
    return true;

  }
  public static function is_valid_id($raw_data)
  {
    $only_letters_numbers = "/^[a-zA-Z0-9]+$/";
    if(!preg_match($only_letters_numbers, $raw_data)) { return false; }
    return true;
  }

}
