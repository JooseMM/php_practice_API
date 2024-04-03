<?php include "./routes.php";

$current_url = $_SERVER['REQUEST_URI'];
$method_type = $_SERVER['REQUEST_METHOD'];
$url_query = array_key_exists('QUERY_STRING', $_SERVER) ? $_SERVER['QUERY_STRING'] : ''; 

switch($method_type) 
{
    case 'GET':
      handle_get_routes($current_url, $url_query);
      break;
    case 'POST':
      $form_data = [ 'name'=>$_POST["name"], 'age'=> $_POST["age"] ];
      handle_post_routes($current_url, $form_data);
      break;
    case 'PUT':
      handle_put_routes($current_url);
      break;
    case 'DELETE':
      handle_delete_routes($current_url);
      break;
}


