<?php
include './database/database_class.php';
include './data_handling/data_tools.php';

class GetController {

	public static function get_all() {
		$response = MyDatabase::get_all();
		Response::send_json($response["successful"], $response["query_result"], $response["message"]);
	}

	public static function get($raw) {
		if(!DataValidation::valid_string_query($raw))
			return Response::send_json(false, NULL, "Invalid query string provided");   
		$arr = Request::to_array($raw);
		if(!array_key_exists("id", $arr)) {
			return Response::send_json(false, NULL, "No id provided");   
		} else if(!Datavalidation::is_valid_id($arr["id"])) {
			return Response::send_json(false, NULL, "Invalid id provided");   
		}
		$res = MyDatabase::get_one($arr['id']);
		return Response::send_json($res["successful"], $res["query_result"], $res["message"]); 
	}
}

class PostController {
	public static function add($raw) {
		if(!DataValidation::is_valid_name($raw["name"])) 
			return Response::send_json(false, NULL, "Invalid name provided"); 
		if(!DataValidation::is_valid_age($raw["age"])) 
			return Response::send_json(false, NULL, "Invalid age provided"); 
		$res = MyDatabase::add_one($raw);
		return Response::send_json($res["successful"], $res["data"] , $res["message"]);

	}
	public static function remove($arr) {
		if(!datavalidation::is_valid_id($arr["id"])) 
			return response::send_json(false, null, "invalid id provided"); 
		$res = mydatabase::remove_one($arr["id"]);
		return response::send_json($res["successful"], $res["query_result"], $res["message"]);
	}
  	public static function update_one($arr) {
		foreach($arr as $val) {
			if($val == NULL || $val === " " || $val === "\n" || $val === "\t")
				return Response::send_json(false, NULL, "Incomplete data provided"); 
		}

		if(!DataValidation::is_valid_id($arr["id"]))
			return Response::send_json(false, NULL, "Invalid ID provided");

		if(!DataValidation::is_valid_name($arr["name"])) 
			return Response::send_json(false, NULL, "Invalid name provided");

		if(!DataValidation::is_valid_age($arr["age"])) 
			return Response::send_json(false, NULL, "Invalid age provided");

		$res = MyDatabase::update_one($arr);
		return Response::send_json($res["successful"], $res["data"], $res["message"]);

	}
}
