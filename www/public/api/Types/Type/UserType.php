<?php

namespace API\Types\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use API\Types\Types;

class UserType extends ObjectType
{
  public function __construct()
  {
    parent::__construct([
      'description' => 'A user',
      'fields' => function () {
        return [
          'id' => Type::id(),
          'username' => Type::string(),
          'lists' => [
            'type' => Type::listOf(Types::list()),
            'resolve' => function ($value, $args, $root) {
              return $root['db']->getUserLists($value['id']);
            }
          ]
        ];
      }
    ]);
  }
}
