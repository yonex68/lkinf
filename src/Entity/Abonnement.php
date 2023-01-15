<?php

namespace App\Entity;

use App\Entity\Traits\Timestamp;
use App\Repository\AbonnementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AbonnementRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Abonnement
{
    use Timestamp;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Stripe::class, inversedBy: 'abonnements')]
    private $stripe;

    #[ORM\OneToOne(inversedBy: 'abonnement', targetEntity: User::class, cascade: ['persist', 'remove'])]
    private $user;

    #[ORM\Column(type: 'boolean')]
    private $statut;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStripe(): ?Stripe
    {
        return $this->stripe;
    }

    public function setStripe(?Stripe $stripe): self
    {
        $this->stripe = $stripe;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }
}
