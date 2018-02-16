<?php
namespace API\Types;

use API\Types\Type\ListItemType;
use API\Types\Type\ListType;
use API\Types\Type\QueryType;
use API\Types\Type\UserType;

class Types
{

  private static $list;
  private static $list_item;
  private static $query;
  private static $user;

  public static function list()
  {
    return self::$list ? : (self::$list = new ListType());
  }

  public static function list_item()
  {
    return self::$list_item ? : (self::$list_item = new ListItemType());
  }

  public static function query()
  {
    return self::$query ? : (self::$query = new QueryType());
  }

  public static function user()
  {
    return self::$user ? : (self::$user = new UserType());
  }

}
