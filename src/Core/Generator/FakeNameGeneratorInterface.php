<?php


namespace Core\Generator;


interface FakeNameGeneratorInterface
{
  public function getName(int $nWords = 2, string $separator = ' '): string;
}