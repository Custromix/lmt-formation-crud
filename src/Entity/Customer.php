<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 */
class Customer
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
     * @ORM\Column(type="string", length=32)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $postal;

    /**
     * @ORM\ManyToOne(targetEntity=CompanyType::class, inversedBy="customers")
     */
    private $CompanyType;

    /**
     * @ORM\OneToMany(targetEntity=Contact::class, mappedBy="Customer", orphanRemoval=true)
     */
    private $contacts;

    /**
     * @ORM\OneToMany(targetEntity=TrainingRequest::class, mappedBy="Customer")
     */
    private $trainingRequests;

    /**
     * @ORM\ManyToMany(targetEntity=Session::class, mappedBy="Customer")
     */
    private $sessions;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
        $this->trainingRequests = new ArrayCollection();
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

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
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

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPostal(): ?int
    {
        return $this->postal;
    }

    public function setPostal(?int $postal): self
    {
        $this->postal = $postal;

        return $this;
    }

    public function getCompanyType(): ?CompanyType
    {
        return $this->CompanyType;
    }

    public function setCompanyType(?CompanyType $CompanyType): self
    {
        $this->CompanyType = $CompanyType;

        return $this;
    }

    /**
     * @return Collection|Contact[]
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
            $contact->setCustomer($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getCustomer() === $this) {
                $contact->setCustomer(null);
            }
        }

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
            $trainingRequest->setCustomer($this);
        }

        return $this;
    }

    public function removeTrainingRequest(TrainingRequest $trainingRequest): self
    {
        if ($this->trainingRequests->removeElement($trainingRequest)) {
            // set the owning side to null (unless already changed)
            if ($trainingRequest->getCustomer() === $this) {
                $trainingRequest->setCustomer(null);
            }
        }

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
            $session->addCustomer($this);
        }

        return $this;
    }

    public function removeSession(Session $session): self
    {
        if ($this->sessions->removeElement($session)) {
            $session->removeCustomer($this);
        }

        return $this;
    }

    /**
     * Initialise tous les attributs nécessaire.
     * @param $customerAttribut
     */
    public function init($customerAttribut): void
    {
        $companyType = new CompanyType();
        $companyType->setId($customerAttribut['companyType']);
        $this->setCompanyType($companyType);
        $this->setName($customerAttribut['name']);
        $this->setCountry($customerAttribut['country']);
        $this->setWebsite($customerAttribut['website']);
        $this->setAddress($customerAttribut['address']);
        $this->setCity($customerAttribut['city']);
        $this->setPostal($customerAttribut['postal']);
    }


}
