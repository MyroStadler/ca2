<?php

include_once __DIR__ . '/../bootstrap.php';

use Implementation\Generator\FakeNameGenerator;
use Implementation\Helper\DI;
use Twig\Environment;

/** @var Environment $twig */
$twig = DI::get(Environment::class);

/** @var FakeNameGenerator $nameGenerator */
$nameGenerator = DI::get(FakeNameGenerator::class);

echo $twig->render('pages/index.html.twig', [
    'page_title' => 'Yo dawg I heard you like non-default page titles, so I...',
    'some_template_var' => $nameGenerator->getName(),
]);