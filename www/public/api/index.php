<?php

namespace API;

// GraphQL and deps
require_once '../vendor/autoload.php';

// GraphQL classes
use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

// API classes
use API\DB\Database;
use API\Types\Types;

// $mutationType = new ObjectType([
//   'name' => 'Mutation',
//   'fields' => [
//     'authenticate' => [
//       'args' => [
//         'username' => Type::nonNull(Type::string()),
//         'password' => Type::nonNull(Type::string())
//       ],
//       'type' => Types::user(),
//       'resolve' => function ($value, $args, $root) {
//         $result = $root['db']->authenticate($args['username'], $args['password']);
//         setcookie('test-cookie-set', 'asdokaosdk', time() + 60 * 60 * 24 * 14, '/', '', false, true);
//         return $result;
//       }
//     ],
//     'createUser' => [
//       'args' => [
//         'username' => Type::nonNull(Type::string()),
//         'password' => Type::nonNull(Type::string())
//       ],
//       'type' => Types::user(),
//       'resolve' => function ($value, $args, $root) {
//         return $root['db']->createUser($args['username'], $args['password']);
//       }
//     ],
//     'createList' => [
//       'args' => [
//         'user_id' => Type::nonNull(Type::int()),
//         'title' => Type::nonNull(Type::string())
//       ],
//       'type' => Types::list(),
//       'resolve' => function ($value, $args, $root) {
//         return $root['db']->createList($args['user_id'], $args['title']);
//       }
//     ],
//     'addListItem' => [
//       'args' => [
//         'list_id' => Type::nonNull(Type::int()),
//         'content' => Type::nonNull(Type::string())
//       ],
//       'type' => Types::list(),
//       'resolve' => function ($value, $args, $root) {
//         return $root['db']->addListItem($args['list_id'], $args['content']);
//       }
//     ]
//   ]
// ]);

$schema = new Schema([
  'query' => Types::query()
]);

$raw_input = file_get_contents('php://input');
$input = json_decode($raw_input, true);
$query = $input['query'];
$vars = empty($input['variables']) ? null : $input['variables'];

try {
  $rootValue = [
    'db' => Database::connect(),
    'session_id' => (empty($_COOKIE['session_id']) ? null : $_COOKIE['session_id'])
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
