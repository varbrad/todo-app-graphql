<?php

namespace API\Types\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class UserType extends ObjectType
{
  public function __construct()
  {
    parent::__construct([
      'description' => 'A user',
      'fields' => [
        'id' => Type::id(),
        'username' => Type::string()
      ]
    ]);
  }
}
