<?php
include './controllers/controllers.php';

function handle_get_routes($url, $raw_query)
{
  $query = Request::validate_query($raw_query);

  switch ($url)
  {
    case "/all":
      GetController::get_all();
      break;
    case "/person/?" . $query: //manually matching the query if present
      GetController::get($query);
      break;
    case "/contact":
      echo "Hello from the contact page!";
      break;
  }
}
function handle_post_routes($url, $raw_data) 
{
  switch($url)
  {
    case "/add":
      PostController::add($raw_data);
      break;
  }
}
function handle_put_routes($url)
{
  //TODO: switch for put request
}
function handle_delete_routes($url)
{
  //TODO: switch for delete request
}
