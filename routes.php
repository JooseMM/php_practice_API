<?php
include './controllers/controllers.php';

function handle_get_routes($url, $raw_query)
{

  switch ($url)
  {
    case "/all":
      GetController::get_all();
      break;
    case "/get/?" . $raw_query: //manually matching the query if present
      GetController::get($raw_query);
      break;
    case "/contact":
      echo "Hello from the contact page!";
      break;
  }
}
function handle_post_routes($url, $nwp) 
{
  switch($url)
  {
    case "/add":
      PostController::add($nwp);
      break;
    case "/remove":
      PostController::remove($nwp);
      break;
    case "/update":
      UpdateController::update_one($nwp);
      break;
  }
}
