<?php
include './controllers/get_controller.php';

function handle_get_routes($url)
{
  switch ($url)
  {
    case '/':
      echo "Hello from the main page!";
      break;
    case '/get-all':
      GetController::get_all();
      break;
    case '/contact':
      echo "Hello from the contact page!";
      break;
  }
}
function handle_post_routes($url)
{
  //TODO: switch for post request
}
function handle_put_routes($url)
{
  //TODO: switch for put request
}
function handle_delete_routes($url)
{
  //TODO: switch for delete request
}
