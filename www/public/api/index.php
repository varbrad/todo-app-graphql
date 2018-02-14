<?php

require_once '../vendor/autoload.php';

require_once 'DB/Database.php';

use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

use API\DB\Database;

$userType = new ObjectType([
  'name' => 'User',
  'description' => 'A user',
  'fields' => [
    'id' => Type::int(),
    'username' => Type::string()
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
        return [
          'id' => $args['id'],
          'title' => 'Test List',
          'user' => 1
        ];
      }
    ]
  ]
]);

$schema = new Schema([
  'query' => $queryType
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
