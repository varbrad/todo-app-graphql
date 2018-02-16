<?php
namespace API\Types;

use API\Types\UserType;

class Types {

  private static $user;

  public static function user() {
    return self::$user ?: (self::$user = new UserType());
  }

}
