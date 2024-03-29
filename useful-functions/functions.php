<?php

function extract_query($query_string)
{
  $multiple_queries = str_contains($query_string, '&');
  var_dump($multiple_queries);

    if($multuple_queries)
    {
      $string_1 = explode($query_string, '&');
      var_dump($string_1);
    }

}


extract_query("id=2&name=Jose");
