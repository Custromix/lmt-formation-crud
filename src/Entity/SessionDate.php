<?php

namespace App\Entity;

use App\Repository\SessionDateRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity(repositoryClass=SessionDateRepository::class)
 */
class SessionDate
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
    private $day;

    /**
     * @ORM\Column(type="date")
     */
    private $dateFormation;

    /**
     * @ORM\ManyToOne(targetEntity=Session::class, inversedBy="SessionDate")
     */
    private $session;

    public function __construct($day, $dateFormation, $session)
    {
        $this->day = $day;
        $this->setDateFormation($dateFormation);
        $this->session = $session;
    }

    public function __toString()
    {
        return $this->day;
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

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getDateFormation(): ?string
    {
        return $this->dateFormation->format("Y-m-d");
    }

    public function setDateFormation(string $dateFormation): self
    {
        $this->dateFormation = new \DateTime($dateFormation);
        return $this;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): self
    {
        $this->session = $session;

        return $this;
    }
}
