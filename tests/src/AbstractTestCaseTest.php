<?php


namespace Test;


class AbstractTestCaseTest extends AbstractTestCase
{
  public function test()
  {
    $this->assertSame('test', $_ENV['APP_ENV']);
  }
}