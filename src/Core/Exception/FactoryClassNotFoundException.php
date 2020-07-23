<?php


namespace Core\Exception;


use Throwable;

class FactoryClassNotFoundException extends \Exception
{
  function __construct($class = "", $code = 0, Throwable $previous = null)
  {
    parent::__construct('Factory class not found' . ($class ? ': ' . $class : ''), $code, $previous);
  }
}