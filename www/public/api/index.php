<?php

require_once '../vendor/autoload.php';

require_once 'DB/Database.php';

use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

use API\DB\Database;

$queryType = new ObjectType([
  'name' => 'Query',
  'fields' => [
    // 'echo' => [
    //   'type' => Type::string(),
    //   'args' => [
    //     'message' => Type::nonNull(Type::string())
    //   ],
    //   'resolve' => function ($root, $args) {
    //     return $root['prefix'] . $args['message'];
    //   }
    // ]
    // 'random' => [
    //   'type' => Type::int(),
    //   'args' => [
    //     'min' => Type::int(),
    //     'max' => Type::int()
    //   ],
    //   'resolve' => function ($root, $args) {
    //     return $args['min'] ?: 0 + $args['max'] ?: 0;
    //   }
    // ]
    'user' => [
      'type' => Type::string(),
      'args' => [
        'id' => Type::nonNull(Type::int())
      ],
      'resolve' => function ($root, $args) {
        return $root['db']->getUsername($args['id']);
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
  $result = GraphQL::executeQuery($schema, $query, $rootValue, null, $vars);
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
