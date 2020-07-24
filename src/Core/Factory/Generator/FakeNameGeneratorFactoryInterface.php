<?php


namespace Core\Factory\Generator;


use Implementation\Generator\FakeNameGenerator;

interface FakeNameGeneratorFactoryInterface
{
  public function create(): FakeNameGenerator;
  public function retrieve(): FakeNameGenerator;
}