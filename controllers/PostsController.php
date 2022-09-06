<?php

class PostsController extends Controller
{
  /**
   * index | Permet de lister tous les posts
   *
   * @return void
   */
  public function index()
  {
    $this->loadModel("Post");
    $perPage = 1;
    $conditions = ["type" => "post", "online" => 1];
    $d["posts"] = $this->Post->findAll([
      "conditions" => $conditions,
      "limit" => ($perPage * ($this->request->page - 1) . "," . $perPage)
    ]);
    $d["total"] = $this->Post->findCount($conditions);
    $d["page"] = ceil($d["total"] / $perPage);
    $this->set($d);
  }

  /**
   * view | Permet d'afficher un post en particulier
   *
   * @param  mixed $id id du post a afficher
   * @return void
   */
  public function view($id)
  {
    $this->loadModel("Post");
    $d["post"] = $this->Post->findFirst([
      "conditions" => ["id" => $id, "type" => "post", "online" => 1]
    ]);
    $this->set($d);
  }
}
