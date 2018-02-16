<?php

namespace API\Types\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

use API\Types\Types;

class ListType extends ObjectType
{
  public function __construct()
  {
    parent::__construct([
      'description' => 'A todo list',
      'fields' => function () {
        return [
          'id' => Type::id(),
          'title' => Type::string(),
          'user' => [
            'type' => Types::user(),
            'resolve' => function ($value, $args, $root) {
              return $root['db']->getUser($value['user']);
            }
          ],
          'items' => [
            'type' => Type::listOf(Types::list_item()),
            'resolve' => function ($value, $args, $root) {
              return $root['db']->getListItems($value['id']);
            }
          ]
        ];
      }
    ]);
  }
}
