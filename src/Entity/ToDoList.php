<?php

namespace App\Entity;

use App\Repository\ToDoListRepository;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Boolean;
/**
 * @ORM\Entity(repositoryClass=ToDoListRepository::class)
 */
class ToDoList
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var (type="string", length=32, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="boolean", length=7, nullable=true)
     */
    private $Contract;

    /**
     * @ORM\Column(type="boolean", length=7, nullable=true)
     */
    private $agreement;

    /**
     * @ORM\Column(type="boolean", length=7, nullable=true)
     */
    private $convocation;

    /**
     * @ORM\Column(type="boolean", length=7, nullable=true)
     */
    private $trainerFolder;

    /**
     * @ORM\Column(type="boolean", length=7, nullable=true)
     */
    private $certificate;

    /**
     * @ORM\Column(type="boolean", length=7, nullable=true)
     */
    private $empowermentTitle;

    /**
     * @ORM\Column(type="boolean", length=7, nullable=true)
     */
    private $invoice;

    /**
     * @ORM\Column(type="boolean", length=7, nullable=true)
     */
    private $survey;

    /**
     * @ORM\Column(type="boolean", length=7, nullable=true)
     */
    private $settlement;

    /**
     * @ORM\Column(type="boolean", length=7, nullable=true)
     */
    private $signInSheet;

    /**
     * @ORM\Column(type="boolean", length=7, nullable=true)
     */
    private $frontPage;

    /**
     * @ORM\OneToOne(targetEntity=Session::class, mappedBy="ToDoList", cascade={"persist", "remove"})
     */
    private $session;

    public function __toString()
    {
        return $this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    public function getContract(): ?bool
    {
        if ($this->Contract == 1){
            return true;
        }else{
            return false;
        }
    }

    public function setContract(?string $Contract): self
    {
        $this->Contract = $Contract;

        return $this;
    }

    public function getAgreement(): ?bool
    {
        return $this->agreement;
    }

    public function setAgreement(?string $agreement): self
    {
        $this->agreement = $agreement;

        return $this;
    }

    public function getConvocation(): ?bool
    {
        return $this->convocation;
    }

    public function setConvocation(?string $convocation): self
    {
        $this->convocation = $convocation;

        return $this;
    }

    public function getTrainerFolder(): ?bool
    {
        return $this->trainerFolder;
    }

    public function setTrainerFolder(?string $trainerFolder): self
    {
        $this->trainerFolder = $trainerFolder;

        return $this;
    }

    public function getCertificate(): ?bool
    {
        return $this->certificate;
    }

    public function setCertificate(?string $certificate): self
    {
        $this->certificate = $certificate;

        return $this;
    }

    public function getEmpowermentTitle(): ?bool
    {
        return $this->empowermentTitle;
    }

    public function setEmpowermentTitle(?string $empowermentTitle): self
    {
        $this->empowermentTitle = $empowermentTitle;

        return $this;
    }

    public function getInvoice(): ?bool
    {
        return $this->invoice;
    }

    public function setInvoice(?string $invoice): self
    {
        $this->invoice = $invoice;

        return $this;
    }

    public function getSurvey(): ?bool
    {
        return $this->survey;
    }

    public function setSurvey(?string $survey): self
    {
        $this->survey = $survey;

        return $this;
    }

    public function getSettlement(): ?bool
    {
        return $this->settlement;
    }

    public function setSettlement(?string $settlement): self
    {
        $this->settlement = $settlement;

        return $this;
    }

    public function getSignInSheet(): ?bool
    {
        return $this->signInSheet;
    }

    public function setSignInSheet(?string $signInSheet): self
    {
        $this->signInSheet = $signInSheet;

        return $this;
    }

    public function getFrontPage(): ?bool
    {
        return $this->frontPage;
    }

    public function setFrontPage(?string $frontPage): self
    {
        $this->frontPage = $frontPage;

        return $this;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): self
    {
        // unset the owning side of the relation if necessary
        if ($session === null && $this->session !== null) {
            $this->session->setToDoList(null);
        }

        // set the owning side of the relation if necessary
        if ($session !== null && $session->getToDoList() !== $this) {
            $session->setToDoList($this);
        }

        $this->session = $session;

        return $this;
    }
}
