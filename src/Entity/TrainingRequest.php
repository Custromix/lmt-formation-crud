<?php

namespace App\Entity;

use App\Repository\TrainingRequestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TrainingRequestRepository::class)
 */
class TrainingRequest
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
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateRequest;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $note;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="trainingRequests")
     */
    private $Customer;

    /**
     * @ORM\ManyToMany(targetEntity=StandardTraining::class, mappedBy="TrainingRequest")
     */
    private $standardTrainings;

    /**
     * @ORM\ManyToMany(targetEntity=CustomizeTraining::class, mappedBy="TainingRequest")
     */
    private $customizeTrainings;

    public function __construct()
    {
        $this->standardTrainings = new ArrayCollection();
        $this->customizeTrainings = new ArrayCollection();
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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getDateRequest(): ?\DateTimeInterface
    {
        return $this->dateRequest;
    }

    public function setDateRequest(\DateTimeInterface $dateRequest): self
    {
        $this->dateRequest = $dateRequest;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->Customer;
    }

    public function setCustomer(?Customer $Customer): self
    {
        $this->Customer = $Customer;

        return $this;
    }

    /**
     * @return Collection|StandardTraining[]
     */
    public function getStandardTrainings(): Collection
    {
        return $this->standardTrainings;
    }

    public function addStandardTraining(StandardTraining $standardTraining): self
    {
        if (!$this->standardTrainings->contains($standardTraining)) {
            $this->standardTrainings[] = $standardTraining;
            $standardTraining->addTrainingRequest($this);
        }

        return $this;
    }

    public function removeStandardTraining(StandardTraining $standardTraining): self
    {
        if ($this->standardTrainings->removeElement($standardTraining)) {
            $standardTraining->removeTrainingRequest($this);
        }

        return $this;
    }

    /**
     * @return Collection|CustomizeTraining[]
     */
    public function getCustomizeTrainings(): Collection
    {
        return $this->customizeTrainings;
    }

    public function addCustomizeTraining(CustomizeTraining $customizeTraining): self
    {
        if (!$this->customizeTrainings->contains($customizeTraining)) {
            $this->customizeTrainings[] = $customizeTraining;
            $customizeTraining->addTrainingRequest($this);
        }

        return $this;
    }

    public function removeCustomizeTraining(CustomizeTraining $customizeTraining): self
    {
        if ($this->customizeTrainings->removeElement($customizeTraining)) {
            $customizeTraining->removeTrainingRequest($this);
        }

        return $this;
    }
}
