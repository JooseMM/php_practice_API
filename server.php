<?php
include "./routes.php";

$current_url = $_SERVER['REQUEST_URI'];
$method_type = $_SERVER['REQUEST_METHOD'];
$url_query = $_SERVER['QUERY_STRING']; 

switch($method_type)
{
    case 'GET':
      handle_get_routes($current_url, $url_query);
      break;
    case 'POST':
      handle_post_routes($current_url);
      break;
    case 'PUT':
      handle_put_routes($current_url);
      break;
    case 'DELETE':
      handle_delete_routes($current_url);
      break;
}

