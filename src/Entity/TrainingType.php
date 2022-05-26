<?php

namespace App\Entity;

use App\Repository\TrainingTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TrainingTypeRepository::class)
 */
class TrainingType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=StandardTraining::class, mappedBy="trainingType")
     */
    private $Training;

    public function __construct()
    {
        $this->Training = new ArrayCollection();
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|StandardTraining[]
     */
    public function getTraining(): Collection
    {
        return $this->Training;
    }

    public function addTraining(StandardTraining $training): self
    {
        if (!$this->Training->contains($training)) {
            $this->Training[] = $training;
            $training->setTrainingType($this);
        }

        return $this;
    }

    public function removeTraining(StandardTraining $training): self
    {
        if ($this->Training->removeElement($training)) {
            // set the owning side to null (unless already changed)
            if ($training->getTrainingType() === $this) {
                $training->setTrainingType(null);
            }
        }

        return $this;
    }
}
