<?php

namespace App\Entity;

use App\Repository\ActionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActionRepository::class)
 */
class ActionTrainee
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=TrainingRequest::class, mappedBy="action")
     */
    private $trainingRequests;

    public function __construct()
    {
        $this->trainingRequests = new ArrayCollection();
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
     * @return Collection|TrainingRequest[]
     */
    public function getTrainingRequests(): Collection
    {
        return $this->trainingRequests;
    }

    public function addTrainingRequest(TrainingRequest $trainingRequest): self
    {
        if (!$this->trainingRequests->contains($trainingRequest)) {
            $this->trainingRequests[] = $trainingRequest;
            $trainingRequest->setAction($this);
        }

        return $this;
    }

    public function removeTrainingRequest(TrainingRequest $trainingRequest): self
    {
        if ($this->trainingRequests->removeElement($trainingRequest)) {
            // set the owning side to null (unless already changed)
            if ($trainingRequest->getAction() === $this) {
                $trainingRequest->setAction(null);
            }
        }

        return $this;
    }
}
