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

$schema = new Schema([
  'query' => Types::query(),
  'mutation' => Types::mutation()
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
