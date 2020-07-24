<?php

//$env_file = '.env.test';
include_once __DIR__ . '/../bootstrap.php';

use Implementation\Generator\FakeNameGenerator;
use Implementation\Helper\DI;
use Twig\Environment as TwigEnvironment;
use Implementation\Factory\Twig\EnvironmentFactory as TwigEnvironmentFactory;
use Implementation\Factory\Generator\FakeNameGeneratorFactory;

// alternative syntax
///** @var TwigEnvironment $twig */
//$twig = DI::retrieve(TwigEnvironment::class);

$twig = (new TwigEnvironmentFactory())->retrieve();


// alternative syntax
///** @var FakeNameGenerator $nameGenerator */
//$nameGenerator = DI::create(FakeNameGenerator::class);

$nameGenerator = (new FakeNameGeneratorFactory())->create();

echo $twig->render('pages/index.html.twig', [
    'page_title' => 'Yo dawg I heard you like non-default page titles, so I...',
    'some_template_var' => $nameGenerator->getName(),
]);