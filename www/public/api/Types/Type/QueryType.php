<?php

namespace API\Types\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

use API\Types\Types;

class QueryType extends ObjectType
{
  public function __construct()
  {
    parent::__construct([
      'description' => 'The query root of the todo-app GraphQL interface.',
      'fields' => [
        'viewer' => [
          'type' => Types::user(),
          'resolve' => function ($value, $args, $root) {
            if ($root['session_id'] === null) return null;
            return $root['db']->viewer($root['session_id']);
          }
        ]
      ]
    ]);
  }
}
