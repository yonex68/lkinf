<?php

namespace App\Entity;

use App\Entity\Traits\Timestamp;
use App\Repository\AvisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvisRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Avis
{
    use Timestamp;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private $contenu;

    #[ORM\Column(type: 'string', length: 255)]
    private $type;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $vendeur;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'avis')]
    private $client;

    #[ORM\ManyToOne(targetEntity: Microservice::class, inversedBy: 'avis')]
    private $microservice;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getVendeur(): ?User
    {
        return $this->vendeur;
    }

    public function setVendeur(?User $vendeur): self
    {
        $this->vendeur = $vendeur;

        return $this;
    }

    public function getMicroservice(): ?Microservice
    {
        return $this->microservice;
    }

    public function setMicroservice(?Microservice $microservice): self
    {
        $this->microservice = $microservice;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): self
    {
        $this->client = $client;

        return $this;
    }
}
