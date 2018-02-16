<?php

namespace API\Types\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class QueryType extends ObjectType
{
  public function __construct()
  {
    parent::__construct([
      'description' => 'The query root of the todo-app GraphQL interface.',
      'fields' => [
        'sessionId' => [
          'type' => Type::id(),
          'resolve' => function ($value, $args, $root) {
            return $root['session_id'];
          }
        ]
      ]
    ]);
  }
}

/*
$queryType = new ObjectType([
  'name' => 'Query',
  'fields' => [
    'user' => [
      'type' => Types::user(),
      'args' => [
        'id' => Type::nonNull(Type::int())
      ],
      'resolve' => function ($value, $args, $root) {
        return $root['db']->getUser($args['id']);
      }
    ],
    'list' => [
      'type' => Types::list(),
      'args' => [
        'id' => Type::nonNull(Type::int())
      ],
      'resolve' => function ($value, $args, $root) {
        return $root['db']->getList($args['id']);
      }
    ]
  ]
]);
 */
