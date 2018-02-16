<?php

namespace API\Types\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use API\Types\Types;

class ListItemType extends ObjectType
{
  public function __construct()
  {
    parent::__construct([
      'description' => 'An item within a list',
      'fields' => function () {
        return [
          'id' => Type::id(),
          'content' => Type::string(),
          'list' => [
            'type' => Types::list(),
            'resolve' => function ($value, $args, $root) {
              return $root['db']->getList($value['list']);
            }
          ]
        ];
      }
    ]);
  }
}
