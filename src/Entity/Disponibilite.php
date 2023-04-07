<?php

namespace App\Entity;

use App\Entity\Traits\Timestamp;
use App\Repository\DisponibiliteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DisponibiliteRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Disponibilite
{
    use Timestamp;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $jour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heureOuverture = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heureCloture = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $ordre = null;

    #[ORM\ManyToOne(inversedBy: 'disponibilites')]
    private ?Microservice $service = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJour(): ?string
    {
        return $this->jour;
    }

    public function setJour(string $jour): self
    {
        $this->jour = $jour;

        return $this;
    }

    public function getHeureOuverture(): ?\DateTimeInterface
    {
        return $this->heureOuverture;
    }

    public function setHeureOuverture(?\DateTimeInterface $heureOuverture): self
    {
        $this->heureOuverture = $heureOuverture;

        return $this;
    }

    public function getHeureCloture(): ?\DateTimeInterface
    {
        return $this->heureCloture;
    }

    public function setHeureCloture(?\DateTimeInterface $heureCloture): self
    {
        $this->heureCloture = $heureCloture;

        return $this;
    }

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(int $ordre): self
    {
        $this->ordre = $ordre;

        return $this;
    }

    public function getService(): ?Microservice
    {
        return $this->service;
    }

    public function setService(?Microservice $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function __toString()
    {
        return $this->getJour();
    }
}
