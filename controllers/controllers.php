<?php
include './database/database_class.php';
include './data_handling/data_tools.php';

class GetController {

	public static function index() {
		$msg = "Hello! I'm Jose Moreno and this is RESTful API written only using native PHP, 
			this was done for educational purposes only and thus is not production ready. 
			The motivation behind this was to solidfy my knowlege in this language 
			also to create an API for future testing and mocking data for front-end apps.

			The documentation for this app is in my repo:
			https://github.com/JooseMM/php_practice_API			

			If you want to see more of me you can go to my portfolio using this links
			https://jamm-portfolio.netlify.app/ 

			GLHF

			-Jose
			";
		Response::send_json(true, NULl, $msg, 200);
	}
	public static function get_all() {
		$res = MyDatabase::get_all();
		Response::send_json($res["successful"], $res["queryResult"], $res["message"], $res["status"]);
	}

	public static function get($raw) {
		if(!DataValidation::valid_string_query($raw))
			return Response::send_json(false, NULL, "Invalid query string provided", 400);   
		$arr = Request::to_array($raw);
		if(!array_key_exists("id", $arr)) {
			return Response::send_json(false, NULL, "No id provided", 400);   
		} else if(!Datavalidation::is_valid_id($arr["id"])) {
			return Response::send_json(false, NULL, "Invalid id provided", 400);   
		}
		$res = MyDatabase::get_one($arr['id']);
		return Response::send_json($res["successful"], $res["queryResult"], $res["message"], $response["status"]); 
	}
}

class PostController {
	public static function add($arr) {
		if(!DataValidation::is_valid_name($arr["name"])) 
			return Response::send_json(false, NULL, "Invalid name provided", 400); 
		if(!DataValidation::is_valid_age($arr["age"])) 
			return Response::send_json(false, NULL, "Invalid age provided", 400); 
		$res = MyDatabase::add_one($arr);
		return Response::send_json($res["successful"], $res["data"] , $res["message"], $res["status"]);

	}
	public static function remove($arr) {
		if(!datavalidation::is_valid_id($arr["id"])) 
			return response::send_json(false, null, "invalid id provided", 400); 
		if(!(MyDatabase::get_one($arr["id"]))["successful"]) 
			return Response::send_json(false, NULL, "No match found", 404); 

		$res = myDatabase::remove_one($arr["id"]);
		return response::send_json(
			$res["successful"],
			$res["queryResult"],
			$res["message"],
			$res["status"]
		);
	}
  	public static function update_one($arr) {
		foreach($arr as $val) {
			if($val == NULL || $val === " " || $val === "\n" || $val === "\t")
				return Response::send_json(false, NULL, "Incomplete data provided", 400); 
		}

		if(!DataValidation::is_valid_id($arr["id"]))
			return Response::send_json(false, NULL, "Invalid ID provided", 400);

		if(!DataValidation::is_valid_name($arr["name"])) 
			return Response::send_json(false, NULL, "Invalid name provided", 400);

		if(!DataValidation::is_valid_age($arr["age"])) 
			return Response::send_json(false, NULL, "Invalid age provided", 400);

		if(!(MyDatabase::get_one($arr["id"]))["successful"])
			return Response::send_json(false, NULL, "No match found", 404); 

		$res = MyDatabase::update_one($arr);
		return Response::send_json($res["successful"], $res["data"], $res["message"], $res["status"]);

	}
}
