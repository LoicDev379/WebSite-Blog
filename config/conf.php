<?php

class Conf
{
  public static $debug = 1;

  public static $databases = [
    "default" => [
      "host" => "localhost",
      "dbname" => "swpp",
      "username" => "loicdev",
      "password" => "pwdroot"
    ]
  ];
}

Router::connect("post/:slug-:id", "posts/view/id:([0-9]+)/slug:([a-z0-9\-]+)");
