<?php

function debug($var)
{
  $debug = debug_backtrace();
  echo '<p><a href="#" onclick="$(this).parent().next().slideToggle(); return false;"><b>' . $debug[0]['file'] . '</b> | ' . $debug[0]['line'] . '</a></p>';

  echo '<ol style="display:none">';
  foreach ($debug as $k => $v) if ($k > 0) {
    echo '<li><b>' . $v['file'] . '</b> | ' . $v['line'] . '</li>';
  }
  echo '</ol>';

  echo '<div class="jumbotron">';
  echo '<pre>';
  print_r($var);
  echo '</pre>';
  echo '</div>';
}
