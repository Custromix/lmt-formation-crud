<?php

namespace App\Entity;

use App\Repository\TrainingRequestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Array_;

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
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $customerName;

    /**
     * @ORM\ManyToMany(targetEntity=StandardTraining::class, mappedBy="TrainingRequest")
     */
    private $standardTrainings;

    /**
     * @ORM\ManyToMany(targetEntity=CustomizeTraining::class, mappedBy="TainingRequest")
     */
    private $customizeTrainings;

    /**
     * @ORM\ManyToOne(targetEntity=ActionTrainee::class, inversedBy="trainingRequests")
     * @ORM\JoinColumn(nullable=false)
     */
    private $action;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_action;

    private $color;

    public function __construct()
    {
        $this->standardTrainings = new ArrayCollection();
        $this->customizeTrainings = new ArrayCollection();
    }

    public function init(array $trainingRequestForm)
    {
        $this->customerName = $trainingRequestForm['customer'];
        $this->name = $trainingRequestForm['name'];
        $this->firstname = $trainingRequestForm['firstname'];
        $this->mail = $trainingRequestForm['mail'];
        $this->phone = $trainingRequestForm['phone'];
        $this->setDateRequest($trainingRequestForm['dateTraining']);
        $this->note = $trainingRequestForm['note'];
        $this->setActionDate($trainingRequestForm['actionDate']);
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

    /**
     * @param mixed $id
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
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

    public function getDateRequest(): ?string
    {
        return $this->dateRequest->format("Y-m-d");
    }

    public function setDateRequest(string $dateRequest): self
    {
        $this->dateRequest = new \DateTime($dateRequest);
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

    /**
     * @return string
     */
    public function getCustomerName(): ?string
    {
        return $this->customerName;
    }

    /**
     * @param string $customerName
     */
    public function setCustomerName($customerName): void
    {
        $this->customerName = $customerName;
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

    public function getAction(): ?ActionTrainee
    {
        return $this->action;
    }

    public function setAction(?ActionTrainee $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getActionDate(): ?string
    {
        return $this->date_action->format("Y-m-d");
    }

    public function setActionDate(string $action_date): self
    {
        $this->date_action = new \DateTime($action_date);

        return $this;
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor(): void
    {
        if (isset($this->date_action)){
            $now = new \DateTime();
            $dateDiff = date_diff($now, $this->date_action);
            if ($dateDiff->days >= 20 && $dateDiff->days < 40)
            {
                $this->color = "#F1D548";

            }elseif($dateDiff->days >= 40)
            {
                $this->color = "#F16748";
            }
        }

    }
}
