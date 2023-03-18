<?php

namespace App\Entity;

use App\Entity\Traits\Timestamp;
use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Categorie
{
    use Timestamp;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $slug;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\Column(type: 'string', length: 7)]
    private $hexColor;

    #[ORM\ManyToMany(targetEntity: Microservice::class, mappedBy: 'categories')]
    private Collection $microservices;

    public function __construct()
    {
        $this->microservices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getHexColor(): ?string
    {
        return $this->hexColor;
    }

    public function setHexColor(string $hexColor): self
    {
        $this->hexColor = $hexColor;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return Collection<int, Microservice>
     */
    public function getMicroservices(): Collection
    {
        return $this->microservices;
    }

    public function addMicroservice(Microservice $microservice): self
    {
        if (!$this->microservices->contains($microservice)) {
            $this->microservices->add($microservice);
            $microservice->addCategory($this);
        }

        return $this;
    }

    public function removeMicroservice(Microservice $microservice): self
    {
        if ($this->microservices->removeElement($microservice)) {
            $microservice->removeCategory($this);
        }

        return $this;
    }
}
