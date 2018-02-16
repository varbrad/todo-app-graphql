<?php

namespace API\DB;

use \PDO;
use API\DB\SafeException;

class Database
{

  private $db;

  static function connect()
  {
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

  public function __construct($pdo)
  {
    $this->db = $pdo;
  }

  public function authenticate($username, $password)
  {
    $stmt = $this->db->prepare(
      'SELECT `user_id` AS `id`, `username`, `password`
       FROM `user`
       WHERE `username` = :username
       LIMIT 1;'
    );
    $stmt->bindValue(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch();
    // If no user found, throw err
    if (empty($user)) throw new SafeException('Invalid username');
    // If password wrong, throw err
    if (!password_verify($password, $user['password'])) throw new SafeException('Invalid password');
    // Everything ok
    // Remove the password from the returned object
    unset($user['password']);
    // Return the object
    return $user;
  }

  public function getUser($userID)
  {
    $stmt = $this->db->prepare(
      'SELECT *
       FROM `user`
       WHERE `user_id` = :user_id
       LIMIT 1;'
    );
    $stmt->bindValue(':user_id', $userID);
    $stmt->execute();
    $result = $stmt->fetch();
    return [
      'id' => $result['user_id'],
      'username' => $result['username']
    ];
  }

  public function createUser($username, $password)
  {
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $this->db->prepare(
      'INSERT INTO `user` (`username`, `password`)
       VALUES (:username, :hash);'
    );
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':hash', $hash);
    $stmt->execute();
    $id = $this->db->lastInsertId();
    return [
      'id' => $id,
      'username' => $username
    ];
  }

  public function getList($list_id)
  {
    $stmt = $this->db->prepare(
      'SELECT *
       FROM `list`
       WHERE `list_id` = :list_id
       LIMIT 1;'
    );
    $stmt->bindValue(':list_id', $list_id);
    $stmt->execute();
    $result = $stmt->fetch();
    return [
      'id' => $result['list_id'],
      'user' => $result['user_id'],
      'title' => $result['title']
    ];
  }

  public function createList($user_id, $title)
  {
    $stmt = $this->db->prepare(
      'INSERT INTO `list` (`user_id`, `title`)
       VALUES (:user_id, :title);'
    );
    $stmt->bindValue(':user_id', $user_id);
    $stmt->bindValue(':title', $title);
    $stmt->execute();
    $id = $this->db->lastInsertId();
    return [
      'id' => $id,
      'user' => $user_id,
      'title' => $title
    ];
  }

  public function getListItems($list_id)
  {
    $stmt = $this->db->prepare(
      'SELECT `list_item_id` AS `id`, `content`
       FROM `list_item`
       WHERE `list_id` = :list_id'
    );
    $stmt->bindValue(':list_id', $list_id);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public function addListItem($list_id, $content)
  {
    $stmt = $this->db->prepare(
      'INSERT INTO `list_item` (`list_id`, `content`)
       VALUES (:list_id, :content);'
    );
    $stmt->bindValue(':list_id', $list_id);
    $stmt->bindValue(':content', $content);
    $stmt->execute();
    return $this->getList($list_id);
  }

}
