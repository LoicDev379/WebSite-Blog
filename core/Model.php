<?php

class Model
{
  static $connections = [];
  public $conf = "default";
  public $table = false;
  public $db;
  public $primaryKey = "id";

  public function __construct()
  {
    // J'initialise quelques variables
    if ($this->table === false) {
      $this->table = strtolower(get_class($this)) . "s";
    }

    // Je me connecte a la BD
    $db = Conf::$databases[$this->conf];
    if (isset(Model::$connections[$this->conf])) {
      $this->db = Model::$connections[$this->conf];
      return true;
    }

    try {
      $pdo = new PDO(
        "mysql:host=" . $db["host"] . ";dbname=" . $db["dbname"],
        $db["username"],
        $db["password"],
        [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
          PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"
        ]
      );
      Model::$connections[$this->conf] = $pdo;
      $this->db = $pdo;
    } catch (PDOException $e) {
      if (Conf::$debug >= 1) {
        die("<b>Erreur : </b>" . $e->getMessage());
      } else {
        die("Impossible de se connecter a la bd!");
      }
    }
  }

  public function findAll($req)
  {
    $sql = "SELECT ";

    if (isset($req["fields"])) {
      is_array($req["fields"])
        ? $sql .= implode(", " . $req["fields"])
        : $sql .= $req["fields"];
    } else {
      $sql .= "*";
    }
    $sql .= " FROM " . $this->table . " AS " . get_class($this);

    // Construction de la condition
    if (isset($req["conditions"])) {
      $sql .= " WHERE ";

      if (!is_array($req["conditions"])) {
        $sql .= $req["conditions"];
      } else {
        $cond = [];
        foreach ($req["conditions"] as $k => $v) {
          if (!is_numeric($v)) {
            $v = $this->db->quote($v);
          }
          $cond[] = "$k = $v";
        }
        $sql .= implode(" AND ", $cond);
      }
    }

    if (isset($req["limit"])) {
      $sql .= " LIMIT " . $req["limit"];
    }

    // die($sql);
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public function findFirst($req)
  {
    return current($this->findAll($req));
  }

  public function findCount($conditions)
  {
    $res = $this->findFirst([
      "fields" => "COUNT($this->primaryKey) AS count",
      "conditions" => $conditions
    ]);
    return $res->count;
  }
}
