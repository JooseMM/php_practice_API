<?php

class Request {
	public static function to_array($qrs) {

		$rgx = '/(\w+)=(\w+)(?:&|$)/';
		preg_match_all($rgx, $qrs, $mat, PREG_SET_ORDER);
		$res = array();
		foreach ($mat as $val) {
			$res[$val[1]] = $val[2];
		}
		return $res;

  	}
	public static function get_specific_params($array) {
		switch(array_key_first($array)) {
		case "name": 
			return [ "name", PDO::PARAM_STR ];
		       	break;
		case "age":
			return [ "age", PDO::PARAM_INT ];
		       	break;
		default:
			return false;
		       	break;
		}
  	}


}

class Response {

	public static function send_json($successful, $data, $message, $status) { 
		$raw_response = [
		       	"successful" => $successful,
			"data" => $data,
			"error"=> $successful ? false : true, "message"=> $message,
			"status"=> $status
		];
		$parse_response = json_encode($raw_response);
		header('Content-Type: application/json');
		echo $parse_response;
  }

}

class DataValidation {

	public static function valid_string_query($str) {
    		$only_string_queries = "/\w+=(?:\w+|\d+)(?:&\w+=(?:\w+|\d+))*/";
		if(!preg_match($only_string_queries, $str)) 
			return false; 
		else 
    			return true;
  }

	public static function is_valid_name($str) {
		$only_letters = "/^[a-zA-Z]+$/"; 
		if(!preg_match($only_letters, $str)) 
			return false; 
		else 
			return true;

  	}
  	public static function is_valid_age($str) {
		$only_age = "/^(?:[1-9]|[1-9][0-9]|1[0-4][0-9]|150)$/";
		if(!preg_match($only_age, $str)) 
			return false; 
		else 
			return true;

  	}
	public static function is_valid_id($str) {
		$only_letters_numbers = "/^[a-zA-Z0-9]+$/";
		if(!preg_match($only_letters_numbers, $str)) 
			return false;
		else
			return true;
  	}

}
