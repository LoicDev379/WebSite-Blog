<?php

class PagesController extends Controller
{
  public function view($id)
  {
    $this->loadModel("Post");

    $d["page"] = $this->Post->findFirst([
      "conditions" => ["id " => $id, "online" => 1, "type" => "page"]
    ]);

    if (empty($d["page"])) {
      $this->e404("Page Introuvable: <b>Vous tentez d'acceder a une ressource qui n'existe pas!</b>");
    }

    // $d["pages"] = $this->Post->findAll([
    //   "conditions" => ["type" => "page", "online" => 1]
    // ]);

    $this->set($d);
  }

  /**
   * getMenu | Permet de recuperer les pages pour le menu
   *
   * @return void
   */
  public function getMenu()
  {
    $this->loadModel("Post");
    return ($this->Post->findAll([
      "conditions" => ["online" => 1, "type" => "page"]
    ]));
  }
}
