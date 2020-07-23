<?php


namespace Implementation\Generator;


use Core\Generator\FakeNameGeneratorInterface;
use Myro\NameStream\Generator;

class FakeNameGenerator implements FakeNameGeneratorInterface
{
  /** @var Generator */
  protected $nameStream;

  function __construct(Generator $nameStream)
  {
    $this->nameStream = $nameStream;
  }

  public function getName(int $nWords = 2, string $separator = ' '): string
  {
    $words = [];
    while ($nWords-- > 0) {
      $words[] = $this->nameStream->generate();
    }
    return implode($separator, $words);
  }
}