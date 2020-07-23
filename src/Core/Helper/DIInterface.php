<?php


namespace Core\Helper;


interface DIInterface
{
  public static function get(string $class, bool $throw = true);
}