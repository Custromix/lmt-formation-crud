<?php

namespace App\Entity;

use App\Repository\StandardTrainingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StandardTrainingRepository::class)
 */
class StandardTraining
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbHours;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $trainingPrice;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $materials;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $reference;

    /**
     * @ORM\ManyToMany(targetEntity=TrainingRequest::class, inversedBy="standardTrainings")
     */
    private $TrainingRequest;

    /**
     * @ORM\ManyToOne(targetEntity=TrainingType::class, inversedBy="Training")
     */
    private $trainingType;

    /**
     * @ORM\OneToMany(targetEntity=Session::class, mappedBy="StandardTraining")
     */
    private $sessions;

    public function __construct()
    {
        $this->TrainingRequest = new ArrayCollection();
        $this->sessions = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id)
    {
        $this->id = $id;
    }

    public function getNom(): ?string
    {
        return $this->name;
    }

    public function setNom(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNbHours(): ?int
    {
        return $this->nbHours;
    }

    public function setNbHours(?int $nbHours): self
    {
        $this->nbHours = $nbHours;

        return $this;
    }

    public function getTrainingPrice(): ?int
    {
        return $this->trainingPrice;
    }

    public function setTrainingPrice(?int $trainingPrice): self
    {
        $this->trainingPrice = $trainingPrice;

        return $this;
    }

    public function getMaterials(): ?string
    {
        return $this->materials;
    }

    public function setMaterials(?string $materials): self
    {
        $this->materials = $materials;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getFamily(): ?string
    {
        return $this->family;
    }

    public function setFamily(?string $family): self
    {
        $this->family = $family;

        return $this;
    }

    /**
     * @return Collection|TrainingRequest[]
     */
    public function getTrainingRequest(): Collection
    {
        return $this->TrainingRequest;
    }

    public function addTrainingRequest(TrainingRequest $trainingRequest): self
    {
        if (!$this->TrainingRequest->contains($trainingRequest)) {
            $this->TrainingRequest[] = $trainingRequest;
        }

        return $this;
    }

    public function removeTrainingRequest(TrainingRequest $trainingRequest): self
    {
        $this->TrainingRequest->removeElement($trainingRequest);

        return $this;
    }

    public function getTrainingType(): ?TrainingType
    {
        return $this->trainingType;
    }

    public function setTrainingType(?TrainingType $trainingType): self
    {
        $this->trainingType = $trainingType;

        return $this;
    }

    /**
     * @return Collection|Session[]
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): self
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions[] = $session;
            $session->setStandardTraining($this);
        }

        return $this;
    }

    public function removeSession(Session $session): self
    {
        if ($this->sessions->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getStandardTraining() === $this) {
                $session->setStandardTraining(null);
            }
        }

        return $this;
    }
}
