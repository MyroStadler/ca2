<?php


namespace Core\Factory\Twig;


use Twig\Environment;

interface EnvironmentFactoryInterface
{
  public function create(): Environment;
  public function retrieve(): Environment;
}