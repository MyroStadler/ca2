<?php

include_once __DIR__ . '/../bootstrap.php';

use Implementation\Factory\Doctrine\ORM\EntityManagerFactory;
use Implementation\Doctrine\Entity\Thing;
use Implementation\Factory\Twig\EnvironmentFactory as TwigEnvironmentFactory;

$twig = (new TwigEnvironmentFactory())->retrieve();

$em = (new EntityManagerFactory())->retrieve();
$thingRepo = $em->getRepository(Thing::class);

// get or create the first sighting - you could build this logic into the repo
if (!$thing = $thingRepo->findOneBy(['shape' => 'Husky'], ['id' => 'ASC'])) {
  $thing = new Thing();
  $thing->setShape('Husky');
  $em->persist($thing);
  $em->flush();
}

echo $twig->render('pages/index.html.twig', [
    'page_title' => 'Thing',
    'some_template_var' => $thing->getShape() . ' ' . $thing->getId(),
]);