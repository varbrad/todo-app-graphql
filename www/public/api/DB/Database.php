<?php

namespace API\DB;

use \PDO;

class Database {

  private $db;

  static function connect() {
    $pdo = new PDO(
      'mysql:host=localhost;dbname=sceqicla_todo',
      'sceqicla_todo',
      'password'
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    return new Database($pdo);
  }

  public function __construct($pdo) {
    $this->db = $pdo;
  }

  public function getUsername($userID) {
    $stmt = $this->db->prepare(
      'SELECT *
       FROM `user`
       WHERE `user_id` = :user_id
       LIMIT 1;'
    );
    $stmt->bindValue(':user_id', $userID);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result['username'];
  }

}
