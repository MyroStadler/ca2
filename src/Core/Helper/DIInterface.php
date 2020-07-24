<?php


namespace Core\Helper;


interface DIInterface
{
  public static function create(string $class, ?array $args = null, bool $throw = true);
  public static function retrieve(string $class, ?array $args = null, bool $throw = true);
}