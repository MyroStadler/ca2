<?php


namespace Implementation\Factory\Twig;


use Core\Factory\Twig\EnvironmentFactoryInterface;
use Implementation\Traits\PersistentInstanceTrait;
use Twig\Environment as Twig;
use Twig\Loader\FilesystemLoader;

class EnvironmentFactory implements EnvironmentFactoryInterface
{
  use PersistentInstanceTrait;

  /**
   * @param bool $new If this is true a new instance is returned, else a new instance is returned
   * @return EnvironmentFactory
   */
  public function create(): Twig
  {
    return $this->getPersistentInstance(function() {
      $loader = new FilesystemLoader(BASE_DIR . '/templates');
      return new Twig($loader);
    });
  }
}