<?php include "./routes.php";

$current_url = $_SERVER["REQUEST_URI"];
$method_type = $_SERVER["REQUEST_METHOD"];
$query_string = array_key_exists("QUERY_STRING", $_SERVER) ? $_SERVER["QUERY_STRING"] : NULL; 

error_reporting(0);
switch ($method_type) {
case "GET":
	handle_get_routes($current_url, $query_string);
	break;
case "POST":
	$form_data = [ "name" => $_POST["name"], "age"=> $_POST["age"], "id" => $_POST["id"] ];
	handle_post_routes($current_url, $form_data);
	break;

default:
	Response::send_json(false, NULL, "Unsupported method", 405);
	break;
}


