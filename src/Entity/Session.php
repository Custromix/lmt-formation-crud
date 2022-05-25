<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SessionRepository::class)
 */
class Session
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $place;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbTrainee;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $estimatePrice;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $numberEstimate;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $purchaseOrder;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $note;

    /**
     * @ORM\OneToMany(targetEntity=SessionDate::class, mappedBy="session")
     */
    private $SessionDate;

    /**
     * @ORM\ManyToOne(targetEntity=Formateur::class, inversedBy="sessions")
     */
    private $Trainer;

    /**
     * @ORM\ManyToOne(targetEntity=Status::class, inversedBy="sessions")
     */
    private $Status;

    /**
     * @ORM\OneToOne(targetEntity=ToDoList::class, inversedBy="session", cascade={"persist", "remove"})
     */
    private $ToDoList;

    /**
     * @ORM\ManyToMany(targetEntity=Customer::class, inversedBy="sessions")
     */
    private $Customer;

    /**
     * @ORM\ManyToOne(targetEntity=StandardTraining::class, inversedBy="sessions")
     */
    private $StandardTraining;

    /**
     * @ORM\ManyToOne(targetEntity=CustomizeTraining::class, inversedBy="sessions")
     */
    private $CustomizeTraining;

    /**
     * @ORM\OneToMany(targetEntity=BePaid::class, mappedBy="Session")
     */
    private $bePaids;

    /*
     * @ORM\OneToOne(targetEntity=ToDoList::class, mappedBy="Session", cascade={"persist", "remove"})
     */

/*
    private $toDoList;
*/

    public function __construct()
    {
        $this->SessionDate = new ArrayCollection();
        $this->Customer = new ArrayCollection();
        $this->bePaids = new ArrayCollection();
    }

    public function init($sessionAttributs){
        $status = new Status();
        $status->setId(intval($sessionAttributs['status']));
        $training = new StandardTraining();
        $training->setId(intval($sessionAttributs['training']));
        $trainer = new Formateur();
        $trainer->setId(intval("0"));
        /*        $trainingCustom = new CustomizeTraining();
        $trainingCustom->setId(intval($sessionAttributs['trainingCustom']));*/

        $this->setPlace($sessionAttributs['place']);
        $this->setEstimatePrice(intval($sessionAttributs['price']));
        $this->setNbTrainee(intval($sessionAttributs['trainee']));
        $this->setNote($sessionAttributs['note']);
        $this->setNumberEstimate($sessionAttributs['note']);
        $this->setStatus($status);
        $this->setStandardTraining($training);
        $this->setTrainer($trainer);
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

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(?string $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getNbTrainee(): ?int
    {
        return $this->nbTrainee;
    }

    public function setNbTrainee(?int $nbTrainee): self
    {
        $this->nbTrainee = $nbTrainee;

        return $this;
    }

    public function getEstimatePrice(): ?int
    {
        return $this->estimatePrice;
    }

    public function setEstimatePrice(?int $estimatePrice): self
    {
        $this->estimatePrice = $estimatePrice;

        return $this;
    }

    public function getNumberEstimate(): ?string
    {
        return $this->numberEstimate;
    }

    public function setNumberEstimate(?string $numberEstimate): self
    {
        $this->numberEstimate = $numberEstimate;

        return $this;
    }

    public function getPurchaseOrder(): ?string
    {
        return $this->purchaseOrder;
    }

    public function setPurchaseOrder(?string $purchaseOrder): self
    {
        $this->purchaseOrder = $purchaseOrder;

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

    /**
     * @return Collection|SessionDate[]
     */
    public function getSessionDate(): Collection
    {
        return $this->SessionDate;
    }

    public function addSessionDate(SessionDate $sessionDate): self
    {
        if (!$this->SessionDate->contains($sessionDate)) {
            $this->SessionDate[] = $sessionDate;
            $sessionDate->setSession($this);
        }

        return $this;
    }

    public function removeSessionDate(SessionDate $sessionDate): self
    {
        if ($this->SessionDate->removeElement($sessionDate)) {
            // set the owning side to null (unless already changed)
            if ($sessionDate->getSession() === $this) {
                $sessionDate->setSession(null);
            }
        }

        return $this;
    }

    public function getTrainer(): ?Formateur
    {
        return $this->Trainer;
    }

    public function setTrainer(?Formateur $Trainer): self
    {
        $this->Trainer = $Trainer;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->Status;
    }

    public function setStatus(?Status $Status): self
    {
        $this->Status = $Status;

        return $this;
    }

    public function getToDoList(): ?ToDoList
    {
        return $this->ToDoList;
    }

    public function setToDoList(?ToDoList $ToDoList): self
    {
        $this->ToDoList = $ToDoList;

        return $this;
    }

    /**
     * @return Collection|Customer[]
     */
    public function getCustomer(): Collection
    {
        return $this->Customer;
    }

    public function addCustomer(Customer $customer): self
    {
        if (!$this->Customer->contains($customer)) {
            $this->Customer[] = $customer;
        }

        return $this;
    }

    public function removeCustomer(Customer $customer): self
    {
        $this->Customer->removeElement($customer);

        return $this;
    }

    public function getStandardTraining(): ?StandardTraining
    {
        return $this->StandardTraining;
    }

    public function setStandardTraining(?StandardTraining $StandardTraining): self
    {
        $this->StandardTraining = $StandardTraining;

        return $this;
    }

    public function getCustomizeTraining(): ?CustomizeTraining
    {
        return $this->CustomizeTraining;
    }

    public function setCustomizeTraining(?CustomizeTraining $CustomizeTraining): self
    {
        $this->CustomizeTraining = $CustomizeTraining;

        return $this;
    }

    /**
     * @return Collection|BePaid[]
     */
    public function getBePaids(): Collection
    {
        return $this->bePaids;
    }

    public function addBePaid(BePaid $bePaid): self
    {
        if (!$this->bePaids->contains($bePaid)) {
            $this->bePaids[] = $bePaid;
            $bePaid->setSession($this);
        }

        return $this;
    }

    public function removeBePaid(BePaid $bePaid): self
    {
        if ($this->bePaids->removeElement($bePaid)) {
            // set the owning side to null (unless already changed)
            if ($bePaid->getSession() === $this) {
                $bePaid->setSession(null);
            }
        }

        return $this;
    }


}
