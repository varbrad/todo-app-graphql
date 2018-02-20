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
            return $root['db']->viewer($root['session_id']);
          }
        ],
        'list' => [
          'type' => Types::list(),
          'args' => [
            'id' => Type::nonNull(Type::id())
          ],
          'resolve' => function ($value, $args, $root) {
            return $root['db']->getList($args['id']);
          }
        ]
      ]
    ]);
  }
}
