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
   * @param array|null $createArgs
   * @param bool $throw
   * @return mixed|null
   * @throws FactoryClassNotFoundException
   * @throws MethodNotFoundException
   */
  public static function create(string $class, array $createArgs = null, bool $throw = true)
  {
    return static::call('create', $class, $createArgs, $throw);
  }

  /**
   * @param string $class
   * @param array|null $createArgs
   * @param bool $throw
   * @return mixed|null
   * @throws FactoryClassNotFoundException
   * @throws MethodNotFoundException
   */
  public static function retrieve(string $class, array $createArgs = null, bool $throw = true)
  {
    return static::call('retrieve', $class, $createArgs, $throw);
  }

  /**
   * @param string $factoryMethod
   * @param string $class
   * @param array|null $createArgs
   * @param bool $throw
   * @return mixed|null
   * @throws FactoryClassNotFoundException
   * @throws MethodNotFoundException
   */
  protected static function call(string $factoryMethod, string $class, array $createArgs = null, bool $throw = true)
  {
    $prefix = 'Implementation\\';
    $c = ltrim(substr($class, 0, strlen($prefix)) == $prefix ? substr($class, strlen($prefix)) : $class, '\\');
    $cFactory = 'Implementation\\Factory\\' . $c . 'Factory';
    if (!class_exists($cFactory)) {
      if ($throw) {
        throw new FactoryClassNotFoundException($cFactory);
      }
      return null;
    }
    $factory = new $cFactory;
    if (!method_exists($factory, $factoryMethod)) {
      if ($throw) {
        throw new MethodNotFoundException($cFactory, $factoryMethod);
      }
      return null;
    }
    return is_null($createArgs) ? $factory->$factoryMethod() : call_user_func([$factory, $factoryMethod], ...$createArgs);
  }
}