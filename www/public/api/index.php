<?php

namespace API;

// GraphQL and deps
require_once '../vendor/autoload.php';

use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

use API\DB\Database;

$userType = new ObjectType([
  'name' => 'User',
  'fields' => [
    'id' => Type::int(),
    'username' => Type::string()
  ]
]);

$itemType = new ObjectType([
  'name' => 'ListItem',
  'description' => 'A list item',
  'fields' => [
    'id' => Type::int(),
    'content' => Type::string()
  ]
]);

$listType = new ObjectType([
  'name' => 'List',
  'description' => 'A todo list',
  'fields' => [
    'id' => Type::int(),
    'title' => Type::string(),
    'user' => [
      'type' => $userType,
      'resolve' => function ($value, $args, $root) {
        return $root['db']->getUser($value['user']);
      }
    ],
    'items' => [
      'type' => Type::listOf($itemType),
      'resolve' => function ($value, $args, $root) {
        return $root['db']->getListItems($value['id']);
      }
    ]
  ]
]);

$queryType = new ObjectType([
  'name' => 'Query',
  'fields' => [
    'user' => [
      'type' => $userType,
      'args' => [
        'id' => Type::nonNull(Type::int())
      ],
      'resolve' => function ($value, $args, $root) {
        return $root['db']->getUser($args['id']);
      }
    ],
    'list' => [
      'type' => $listType,
      'args' => [
        'id' => Type::nonNull(Type::int())
      ],
      'resolve' => function ($value, $args, $root) {
        return $root['db']->getList($args['id']);
      }
    ]
  ]
]);

$mutationType = new ObjectType([
  'name' => 'Mutation',
  'fields' => [
    'authenticate' => [
      'args' => [
        'username' => Type::nonNull(Type::string()),
        'password' => Type::nonNull(Type::string())
      ],
      'type' => $userType,
      'resolve' => function ($value, $args, $root) {
        $result = $root['db']->authenticate($args['username'], $args['password']);
        setcookie('test-cookie-set', 'asdokaosdk', time() + 60 * 60 * 24 * 14, '/', '', false, true);
        return $result;
      }
    ],
    'createUser' => [
      'args' => [
        'username' => Type::nonNull(Type::string()),
        'password' => Type::nonNull(Type::string())
      ],
      'type' => $userType,
      'resolve' => function ($value, $args, $root) {
        return $root['db']->createUser($args['username'], $args['password']);
      }
    ],
    'createList' => [
      'args' => [
        'user_id' => Type::nonNull(Type::int()),
        'title' => Type::nonNull(Type::string())
      ],
      'type' => $listType,
      'resolve' => function ($value, $args, $root) {
        return $root['db']->createList($args['user_id'], $args['title']);
      }
    ],
    'addListItem' => [
      'args' => [
        'list_id' => Type::nonNull(Type::int()),
        'content' => Type::nonNull(Type::string())
      ],
      'type' => $listType,
      'resolve' => function ($value, $args, $root) {
        return $root['db']->addListItem($args['list_id'], $args['content']);
      }
    ]
  ]
]);

$schema = new Schema([
  'query' => $queryType,
  'mutation' => $mutationType
]);

$raw_input = file_get_contents('php://input');
$input = json_decode($raw_input, true);
$query = $input['query'];
$vars = empty($input['variables']) ? null : $input['variables'];

try {
  $rootValue = [
    'db' => Database::connect()
  ];
  $result = GraphQL::executeQuery($schema, $query, null, $rootValue, $vars);
  $output = $result->toArray();
} catch (\Exception $e) {
  $output = [
    'errors' => [
      [
        'message' => $e->getMessage()
      ]
    ]
  ];
}

header('Content-Type: application/json; charset=UTF-8');
echo json_encode($output);
