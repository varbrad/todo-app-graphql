<?php

namespace API\Types\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ListItemType extends ObjectType
{
  public function __construct()
  {
    parent::__construct([
      'description' => 'An item within a list',
      'fields' => [
        'id' => Type::id(),
        'content' => Type::string()
      ]
    ]);
  }
}
