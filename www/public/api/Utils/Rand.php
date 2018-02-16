<?php

namespace API\Utils;

class Rand
{

  const AZaz09 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  const az09 = 'abcdefghijklmnopqrstuvwxyz0123456789';

  public static function chars($length, $charset = Rand::az09)
  {
    $s = '';
    $max = strlen($charset) - 1;
    for ($i = 0; $i < $length; ++$i) {
      $rand = mt_rand(0, $max);
      $s .= $charset[$rand];
    }
    return $s;
  }

}
