<?php

namespace App\Entity;

use App\Entity\Traits\Timestamp;
use App\Repository\FavorisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavorisRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Favoris
{
    use Timestamp;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'favoris')]
    private $client;

    #[ORM\ManyToOne(targetEntity: Microservice::class, inversedBy: 'favoris')]
    private $microservice;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMicroservice(): ?Microservice
    {
        return $this->microservice;
    }

    public function setMicroservice(?Microservice $microservice): self
    {
        $this->microservice = $microservice;

        return $this;
    }
}
