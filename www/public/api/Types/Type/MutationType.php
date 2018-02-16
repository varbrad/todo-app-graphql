<?php

namespace API\Types\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use API\Types\Types;

class MutationType extends ObjectType
{
  public function __construct()
  {
    parent::__construct([
      'description' => 'The mutation root of the todo-app GraphQL interface.',
      'fields' => [
        'authenticate' => [
          'type' => Types::user(),
          'args' => [
            'username' => Type::nonNull(Type::string()),
            'password' => Type::nonNull(Type::string()),
            'persistent' => Type::boolean()
          ],
          'resolve' => function ($value, $args, $root) {
            if (empty($args['persistent'])) $args['persistent'] = false;
            return $root['db']->authenticate($args['username'], $args['password'], $args['persistent']);
          }
        ],
        'logout' => [
          'type' => Type::boolean(),
          'resolve' => function ($value, $args, $root) {
            return $root['db']->logout($root['session_id']);
          }
        ]
      ]
    ]);
  }
}
