<?php


namespace Implementation\Traits;


trait PersistentInstanceTrait
{

  protected static $persistentInstance;

  /**
   * If you want a persistent instance, wrap your creation logic in a closure and ask me to do it as needed
   * @param callable $creationClosure This function closure should return the class instance the factory produces. I'll use it if I need to
   * @param bool $new For flexibility, if this is true the persistent instance will be left untouched, a new instance being returned instead
   * @return mixed|null
   */
  public function getPersistentInstance(callable $creationClosure, bool $new = false)
  {
    if ($new) {
      return $creationClosure();
    }
    if (!static::$persistentInstance) {
      static::$persistentInstance = $creationClosure();
    }
    return static::$persistentInstance;
  }
}