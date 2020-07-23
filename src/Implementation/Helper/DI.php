<?php


namespace Implementation\Helper;


use Core\Exception\FactoryClassNotFoundException;
use Core\Exception\MethodNotFoundException;
use Core\Helper\DIInterface;
use Implementation\Factory\DependencyInjection\ContainerFactory;
use League\Container\Container;

/**
 * The whole idea here is if you ask for something I'll try its factory's create method.
 * Class DI
 * @package Implementation\Helper
 */
class DI implements DIInterface
{
  /**
   * @param string $class
   * @param bool $new
   * @return mixed|null
   * @throws FactoryClassNotFoundException
   */
  public static function get(string $class, bool $throw = true)
  {
    $prefix = 'Implementation\\';
    $c = ltrim(substr($class, 0, strlen($prefix)) == $prefix ? substr($class, strlen($prefix)) : $class, '\\');
    $cFactory = 'Implementation\\Factory\\' . $c . 'Factory';
    if (!class_exists($cFactory)) { // TODO: check for typeof relevant interface or if function exists, improve error handling
      if ($throw) {
        throw new FactoryClassNotFoundException($cFactory);
      }
      return null;
    }
    $factory = new $cFactory;
    if (!method_exists($factory, 'create')) {
      if ($throw) {
        throw new MethodNotFoundException($cFactory, 'create');
      }
      return null;
    }
    return $factory->create();
  }
}