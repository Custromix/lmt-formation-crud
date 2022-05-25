<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 */
class Contact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private $civility;

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
    private $mobilePhone;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $landlinePhone;

    /**
     * @ORM\ManyToOne(targetEntity=ContactType::class, inversedBy="contacts")
     */
    private $ContactType;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="contacts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Customer;

    public function __construct($aCivility, $aContactType, $aName, $aFirstname, $aMail, $aMobilePhone, $aLandlinePhone)
    {
        $contactType = new ContactType();
        $contactType->setId($aContactType);
        $this->civility = $aCivility;
        $this->ContactType = $contactType;
        $this->name = $aName;
        $this->firstname = $aFirstname;
        $this->mail = $aMail;
        $this->mobilePhone = $aMobilePhone;
        $this->landlinePhone = $aLandlinePhone;
    }

    public function __toString()
    {
        return $this->name . " " . $this->firstname;
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

    public function getCivility(): ?string
    {
        return $this->civility;
    }

    public function setCivility(string $civility): self
    {
        $this->civility = $civility;

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

    public function getMobilePhone(): ?string
    {
        return $this->mobilePhone;
    }

    public function setMobilePhone(?string $mobilePhone): self
    {
        $this->mobilePhone = $mobilePhone;

        return $this;
    }

    public function getLandlinePhone(): ?string
    {
        return $this->landlinePhone;
    }

    public function setLandlinePhone(?string $landlinePhone): self
    {
        $this->landlinePhone = $landlinePhone;

        return $this;
    }

    public function getContactType(): ?ContactType
    {
        return $this->ContactType;
    }

    public function setContactType(?ContactType $ContactType): self
    {
        $this->ContactType = $ContactType;

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
}
