<?php


namespace Implementation\Factory\Twig;


use Core\Factory\Twig\EnvironmentFactoryInterface;
use Implementation\Traits\PersistentInstanceTrait;
use Twig\Environment as Twig;
use Twig\Loader\FilesystemLoader;

class EnvironmentFactory implements EnvironmentFactoryInterface
{
  use PersistentInstanceTrait;

  public function create(): Twig
  {
    $loader = new FilesystemLoader(BASE_DIR . '/templates');
    return new Twig($loader);
  }

  public function retrieve(): Twig
  {
    return $this->getPersistentInstance([$this, 'create']);
  }
}