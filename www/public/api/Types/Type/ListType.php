<?php

namespace API\Types\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

use API\Types\Types;

class ListType extends ObjectType
{
  public function __construct()
  {
    parent::__construct([
      'description' => 'A todo list',
      'fields' => [
        'id' => Type::id(),
        'title' => Type::string()
      ]
    ]);
  }
}
