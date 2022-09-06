<?php

class Dispatcher
{
  public $request;

  public function __construct()
  {
    $this->request = new Request();
    Router::Parse($this->request->url, $this->request);
    $controller = $this->loadController();
    // $controller->view();
    if (!in_array($this->request->action, array_diff(get_class_methods($controller), get_class_methods(get_parent_class($controller))))) {
      $this->error("Le controller <b>" . $this->request->controller . "</b> n'a pas de methode <b>" . $this->request->action . "</b>");
    }
    // debug($this->request->params);
    call_user_func_array([$controller, $this->request->action], $this->request->params);
    $controller->render($this->request->action);
  }

  public function loadController()
  {
    $controllerName = ucfirst($this->request->controller) . "Controller";
    require ROOT . "controllers" . DS . $controllerName . ".php";
    return new $controllerName($this->request);
  }

  public function error($message)
  {
    $controller = new Controller($this->request);
    $controller->e404($message);
  }
}
