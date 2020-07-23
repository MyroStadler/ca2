<?php


namespace Core\Exception;


use Throwable;

class MethodNotFoundException extends \Exception
{
  function __construct(string $class, string $method, $code = 0, Throwable $previous = null)
  {
    parent::__construct(sprintf('Method not found: method %s of class %s', $method, $class), $code, $previous);
  }
}