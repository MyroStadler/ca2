<?php

require __DIR__ . '/bootstrap.php';

$em = (new \Implementation\Factory\Doctrine\ORM\EntityManagerFactory())->retrieve();
$loader = new \Doctrine\Common\DataFixtures\Loader();
$loader->loadFromDirectory(BASE_DIR . '/fixtures/src');

$purger = new \Doctrine\Common\DataFixtures\Purger\ORMPurger();
$executor = new \Doctrine\Common\DataFixtures\Executor\ORMExecutor($em, $purger);
$executor->execute($loader->getFixtures());
