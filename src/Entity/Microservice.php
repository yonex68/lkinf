<?php

namespace App\Entity;

use App\Entity\Traits\Timestamp;
use App\Repository\MicroserviceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MicroserviceRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Microservice
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

    #[ORM\ManyToMany(targetEntity: Media::class, inversedBy: 'microservices', cascade: ["persist"])]
    private $medias;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'microservices')]
    private $vendeur;

    #[ORM\Column(type: 'boolean')]
    private $online;

    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'microservices')]
    private $categorie;

    #[ORM\ManyToMany(targetEntity: Prix::class, inversedBy: 'microservices', cascade: ["persist"])]
    private $prix;

    #[ORM\OneToMany(mappedBy: 'microservice', targetEntity: Commande::class)]
    private $commandes;

    #[ORM\OneToMany(mappedBy: 'microservice', targetEntity: Avis::class)]
    private $avis;

    #[ORM\OneToMany(mappedBy: 'microservice', targetEntity: Favoris::class)]
    private $favoris;

    public function __construct()
    {
        $this->medias = new ArrayCollection();
        $this->prix = new ArrayCollection();
        $this->commandes = new ArrayCollection();
        $this->avis = new ArrayCollection();
        $this->favoris = new ArrayCollection();
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

    /**
     * @return Collection|Media[]
     */
    public function getMedias(): Collection
    {
        return $this->medias;
    }

    public function addMedia(Media $media): self
    {
        if (!$this->medias->contains($media)) {
            $this->medias[] = $media;
        }

        return $this;
    }

    public function removeMedia(Media $media): self
    {
        $this->medias->removeElement($media);

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

    public function getOnline(): ?bool
    {
        return $this->online;
    }

    public function setOnline(bool $online): self
    {
        $this->online = $online;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection|Prix[]
     */
    public function getPrix(): Collection
    {
        return $this->prix;
    }

    public function addPrix(Prix $prix): self
    {
        if (!$this->prix->contains($prix)) {
            $this->prix[] = $prix;
        }

        return $this;
    }

    public function removePrix(Prix $prix): self
    {
        $this->prix->removeElement($prix);

        return $this;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setMicroservice($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getMicroservice() === $this) {
                $commande->setMicroservice(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Avis[]
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): self
    {
        if (!$this->avis->contains($avi)) {
            $this->avis[] = $avi;
            $avi->setMicroservice($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): self
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getMicroservice() === $this) {
                $avi->setMicroservice(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Favoris[]
     */
    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

    public function addFavori(Favoris $favori): self
    {
        if (!$this->favoris->contains($favori)) {
            $this->favoris[] = $favori;
            $favori->setMicroservice($this);
        }

        return $this;
    }

    public function removeFavori(Favoris $favori): self
    {
        if ($this->favoris->removeElement($favori)) {
            // set the owning side to null (unless already changed)
            if ($favori->getMicroservice() === $this) {
                $favori->setMicroservice(null);
            }
        }

        return $this;
    }

    /**
     * Verifi si ce microcervice a déjà ajouter en favoris par un utilisateur
     *
     * @param User $user
     * @return boolean
     */
    public function isAddedByUser(User $user){
        foreach($this->favoris as $favori){
            if($favori->getClient() === $user) return true;
        }

        return false;
    }
}
