<?php

namespace App\Entity;

use App\Entity\Traits\Created;
use App\Repository\CommandeMessageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CommandeMessageRepository::class)]
#[ORM\HasLifecycleCallbacks]
class CommandeMessage
{
    use Created;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    /**
     * @Groups("message")
     */
    private $id;

    #[ORM\Column(type: 'text')]
    /**
     * @Groups("message")
     */
    private $contenu;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'commandeMessages')]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    /**
     * @Groups("message")
     */
    private $user;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'commandeMessages')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    /**
     * @Groups("message")
     */
    private $commande;

    #[ORM\Column(type: 'boolean')]
    private $lu;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    public function getLu(): ?bool
    {
        return $this->lu;
    }

    public function setLu(bool $lu): self
    {
        $this->lu = $lu;

        return $this;
    }
}
