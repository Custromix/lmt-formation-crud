<?php

namespace App\Entity;

use App\Repository\BePaidRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BePaidRepository::class)
 */
class BePaid
{

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facture;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=FinancingType::class)
     */
    private $FinancingType;

    /**
     * @ORM\ManyToOne(targetEntity=Session::class, inversedBy="bePaids")
     */
    private $Session;

    public function __construct(FinancingType $financingType, Session $session)
    {
        $this->FinancingType = $financingType;
        $this->Session = $session;
    }

    public function getFacture(): ?string
    {
        return $this->facture;
    }

    public function setFacture(?string $facture): self
    {
        $this->facture = $facture;

        return $this;
    }

    public function getFinancingType(): ?FinancingType
    {
        return $this->FinancingType;
    }

    public function setFinancingType(?FinancingType $FinancingType): self
    {
        $this->FinancingType = $FinancingType;

        return $this;
    }

    public function getSession(): ?Session
    {
        return $this->Session;
    }

    public function setSession(?Session $Session): self
    {
        $this->Session = $Session;

        return $this;
    }
}
