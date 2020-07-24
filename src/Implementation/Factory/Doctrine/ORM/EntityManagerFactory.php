<?php


namespace Implementation\Factory\Doctrine\ORM;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Implementation\Traits\PersistentInstanceTrait;

class EntityManagerFactory
{
  use PersistentInstanceTrait;

  public function create(): EntityManager
  {
    $isDevMode = true;
    $proxyDir = null;
    $cache = null;
    $useSimpleAnnotationReader = false;
    $config = Setup::createAnnotationMetadataConfiguration(array(BASE_DIR . "/src/Implementation/Doctrine/Entity"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);
    $conn = [
        'dbname' => $_ENV['DB_NAME'],
        'user' => 'root',
        'password' => $_ENV['DB_ROOT_PASSWORD'],
        'host' => $_ENV['DB_HOST'],
        'driver' => 'pdo_mysql',
    ];
    $entityManager = EntityManager::create($conn, $config);
    return $entityManager;
  }

  public function retrieve(): EntityManager
  {
    return $this->getPersistentInstance([$this, 'create']);
  }
}