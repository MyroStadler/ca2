<?php

namespace Fixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Implementation\Doctrine\Entity\Thing;

class ThingFixtures implements FixtureInterface
{
  public function load(ObjectManager $om)
  {
    $thing = new Thing();
    $thing->setShape('Husky');
    $om->persist($thing);
    $om->flush();
  }
}