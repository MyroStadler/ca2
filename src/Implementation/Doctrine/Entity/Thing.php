<?php

namespace Implementation\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Implementation\Doctrine\Repository\ThingRepository")
 * @ORM\Table(name="thing")
 */
class Thing
{
  /**
   * @var int|null
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue
   */
  protected $id;

  /**
   * @var string|null
   * @ORM\Column(type="string")
   */
  protected $shape;

  /**
   * @var int|null
   * @ORM\Column(type="integer")
   */
  protected $parent_id;

  /**
   * @return int|null
   */
  public function getId(): ?int
  {
    return $this->id;
  }

  /**
   * @return string|null
   */
  public function getShape(): ?string
  {
    return $this->shape;
  }

  /**
   * @param string|null $shape
   * @return Thing
   */
  public function setShape(?string $shape): self
  {
    $this->shape = $shape;
    return $this;
  }

  /**
   * @return int|null
   */
  public function getParentId(): ?int
  {
    return $this->parent_id;
  }

  /**
   * @param int|null $parent_id
   * @return Thing
   */
  public function setParentId(?int $parent_id): self
  {
    $this->parent_id = $parent_id;
    return $this;
  }

}