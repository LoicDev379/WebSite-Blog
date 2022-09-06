<?php

class Controller
{
  public $request;              // Objet request
  public $vars = [];            // Variable a passer a la vue
  private $layout = "default";  // layout a utiliser pour rendre la vue
  private $rendered = false;    // Si le rendu a ete fait ou pas

  /**
   * __construct | Constructeur
   * @param  mixed $request | Objet request de notre appli
   */
  public function __construct($request = null)
  {
    if ($request) {
      $this->request = $request;  // On stocke la request dans l'instance
    }
  }

  /**
   * render | Permet de rendre une vue
   * @param  mixed $viewName | Fichier a rendre (chemin depuis une vue ou nom de la vue)
   */
  public function render($viewName)
  {
    if ($this->rendered) {
      return false;
    }
    extract($this->vars);
    if (strpos($viewName, "/") === 0) {
      $viewName = ROOT . "views" . DS . "errors" . DS . "404";
    } else {
      $viewName = ROOT . "views" . DS . $this->request->controller . DS . $viewName;
    }
    ob_start();
    require $viewName . ".php";
    $content_for_layout = ob_get_clean();
    require ROOT . "views" . DS . "layout" . DS . $this->layout . ".php";
    $this->rendered = true;
  }

  /**
   * set | Permet de passer une ou plusieurs variables a la vue
   *
   * @param  mixed $key   | Nom de la var ou tableau de variables
   * @param  mixed $value | Valeur de la variable
   * @return void
   */
  public function set($key, $value = null)
  {
    if (is_array($key)) {
      $this->vars += $key;
    } else {
      $this->vars[$key] = $value;
    }
  }

  /**
   * loadModel | Permet de charger un model
   *
   * @param  mixed $nameModel
   * @return void
   */
  public function loadModel($nameModel)
  {
    $file = ROOT . "models" . DS . $nameModel . ".php";
    require_once $file;
    if (!isset($this->$nameModel)) {
      $this->$nameModel = new $nameModel();
    }
  }

  /**
   * e404 | Permet de gerer les erreurs 404
   *
   * @param  mixed $message message d'erreur a envoyer a la vue
   * @return void
   */
  public function e404($message)
  {
    header("HTTP/1.0 404 Not Found");
    $this->set("message", $message);
    $this->render("/error/404");
    die();
  }
  
  /**
   * request | Permet d'appeller un controller depuis une vue
   *
   * @param  mixed $controller
   * @param  mixed $action
   * @return void
   */
  public function request($controller, $action)
  {
    $controller .= "Controller";
    require_once ROOT . "controllers" . DS . $controller . ".php";
    $c = new $controller();
    return $c->$action();
  }
}
