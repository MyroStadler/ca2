<?php


namespace Implementation\Factory\Generator;


use Core\Factory\Generator\FakeNameGeneratorFactoryInterface;
use Implementation\Generator\FakeNameGenerator;
use Myro\NameStream\Generator;

class FakeNameGeneratorFactory implements FakeNameGeneratorFactoryInterface
{
  public function create(): FakeNameGenerator
  {
    return new FakeNameGenerator(new Generator());
  }
}