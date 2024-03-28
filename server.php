<?php
include "./controllers.php";

$current_url = $_SERVER['REQUEST_URI'];
$method_type = $_SERVER['REQUEST_METHOD'];

switch($method_type)
{
    case 'GET':
      handle_get_routes($current_url);
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

