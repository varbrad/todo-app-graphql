<?php

namespace API\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class UserType extends ObjectType
{
  public function __construct() {
    parent::__construct([
      'description' => 'A user',
      'fields' => [
        'id' => Type::int(),
        'username' => Type::string()
      ]
    ]);
  }
}
