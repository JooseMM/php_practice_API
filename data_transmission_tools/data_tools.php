<?php

class Request
{
  public static function translate_query($query_string)
  {
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

  public static function validate_query($raw_query)
  {
    if(str_contains($raw_query, '=') && strlen($raw_query) > 3)
    {
      return $raw_query;
    }
    return NULL;
  }

  public static function is_valid_input($raw_data)
  {
    $only_letters = '/^[a-zA-Z]+$/'; // Pattern to match only letters
    $only_age = '/^(?:0|1[0-4]?[0-9]|150)$/'; // Pattern to match numbers from 0 to 150

    if(!preg_match($only_letters, $raw_data['name']) || !preg_match($only_age, $raw_data['age'])) {
      return false;
    } 
    return true;
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
  public static function not_empty_string($string)
  {
    if($string === "" || $string === " " || $string = "\n" || $string = "\t")
    {
      return false;
    } 
    return $string;
  }
}
