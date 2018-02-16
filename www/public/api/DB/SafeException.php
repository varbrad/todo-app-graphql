<?php

namespace API\DB;

use GraphQL\Error\ClientAware;

class SafeException extends \Exception implements ClientAware
{

  public function isClientSafe()
  {
    return true;
  }

  public function getCategory()
  {
    return 'SafeException';
  }

}
