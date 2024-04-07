<?php
include './controllers/controllers.php';

function handle_get_routes($url, $raw_query) {

	switch ($url) {
	case "/all":
      		GetController::get_all();
      		break;
    	case "/get/?" . $raw_query: //manually matching the query if present
      		GetController::get($raw_query);
      		break;
    	case "/contact":
      		echo "Hello from the contact page!";
      		break;
	default:
		Response::send_json(false, NULL, "Invalid path", 404);
		break;
  	}
}
function handle_post_routes($url, $nwp) {
	switch($url) {
    	case "/add":
      		PostController::add($nwp);
		break;
    	case "/remove":
      		PostController::remove($nwp);
      		break;
    	case "/update":
      		PostController::update_one($nwp);
      		break;
	default:
		Response::send_json(false, NULL, "Invalid path", 404);
		break;
  }
}
