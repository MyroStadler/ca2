<?php


namespace Implementation\Factory\Generator;


use Core\Factory\Generator\FakeNameGeneratorFactoryInterface;
use Implementation\Generator\FakeNameGenerator;
use Implementation\Traits\PersistentInstanceTrait;
use Myro\NameStream\Generator;

class FakeNameGeneratorFactory implements FakeNameGeneratorFactoryInterface
{
  use PersistentInstanceTrait;

  public function create(): FakeNameGenerator
  {
    return new FakeNameGenerator(new Generator());
  }

  public function retrieve(): FakeNameGenerator
  {
    return $this->getPersistentInstance([$this, 'create']);
  }
}