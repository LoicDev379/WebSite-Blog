<?php

class Router
{
  public $url;
  public static $routes = []; // Tableau contenant les informations sur chacune des routes
  /**
   * Parse
   * @param  mixed $url a parser
   * @return array contenant les parametres
   **/
  public static function Parse($url, $request)
  {
    $url = trim($url, "/");

    foreach (Router::$routes as $v) {
      if (preg_match($v["catcher"], $url, $match)) {
        debug($match);
        $request->controller = $v["controller"];
        $request->action = $v["action"];
        $request->params = [];
        foreach ($v["params"] as $k => $v) {
          $request->params[$k] = $match[$k];
        }
        return $request;
        // debug($request);
      }
    }

    $params = explode("/", $url);
    $request->controller = $params[0];
    $request->action = isset($params[1]) ? $params[1] : "index";
    $request->params = array_slice($params, 2);
    return true;
  }

  public static function connect($redir, $url)
  {
    $r = [];

    $r["params"] = [];
    $r["redir"] = $redir;

    $r["origin"] = preg_replace('/([a-z0-9]+):([^\/]+)/', '$1:(?P<$1>$2)', $url);
    $r["origin"] = "/" . str_replace("/", "\/", $r["origin"]) . "/";

    debug($url);
    $params = explode("/", $url);

    foreach ($params as $k => $v) {
      // debug($k);
      if (strpos($v, ":")) {
        $p = explode(":", $v);
        $r["params"][$p[0]] = $p[1];
      } else {
        if ($k == 0) {
          $r["controller"] = $v;
        } elseif ($k == 1) {
          $r["action"] = $v;
        }
      }
    }

    $r["catcher"] = $redir;
    // debug($r["catcher"]);
    foreach ($r['params'] as $k => $v) {
      $r["catcher"] = str_replace(":$k", "(?P<$k>$v)", $r["catcher"]);
    }
    $r["catcher"] = "/" . str_replace("/", "\/", $r["catcher"]) . "/";

    self::$routes[] = $r;
    debug($r);
  }

  public static function url($url)
  {
    foreach (self::$routes as $r) {
      if (preg_match($r["origin"], $url, $match)) {
        foreach ($match as $k => $w) {
          if (!is_numeric($k)) {
            $r["redir"] = str_replace(":$k", $w, $r["redir"]);
          }
        }
        return $r["redir"];
      }
    }
    return $url;
  }
}
