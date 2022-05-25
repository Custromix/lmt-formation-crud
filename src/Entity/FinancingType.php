<?php

namespace App\Entity;

use App\Repository\FinancingTypeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FinancingTypeRepository::class)
 */
class FinancingType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    private $oldId;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $name;

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getOldId()
    {
        return $this->oldId;
    }

    /**
     * @param mixed $oldId
     */
    public function setOldId($oldId): void
    {
        $this->oldId = $oldId;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
