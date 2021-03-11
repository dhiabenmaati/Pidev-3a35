<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_prod;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $desc_prod;

    /**
     * @ORM\Column(type="float")
     */
    private $prix_prod;

    /**
     * @ORM\Column(type="integer")
     */
    private $qte_prod;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image_prod;

    /**
     * @ORM\Column(type="boolean")
     */
    private $valid_prod;

    /**
     * @ORM\OneToMany(targetEntity=DetailCommande::class, mappedBy="produit")
     */
    private $detailCommandes;

    public function __construct()
    {
        $this->detailCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProd(): ?string
    {
        return $this->nom_prod;
    }

    public function setNomProd(string $nom_prod): self
    {
        $this->nom_prod = $nom_prod;

        return $this;
    }

    public function getDescProd(): ?string
    {
        return $this->desc_prod;
    }

    public function setDescProd(string $desc_prod): self
    {
        $this->desc_prod = $desc_prod;

        return $this;
    }

    public function getPrixProd(): ?float
    {
        return $this->prix_prod;
    }

    public function setPrixProd(float $prix_prod): self
    {
        $this->prix_prod = $prix_prod;

        return $this;
    }

    public function getQteProd(): ?int
    {
        return $this->qte_prod;
    }

    public function setQteProd(int $qte_prod): self
    {
        $this->qte_prod = $qte_prod;

        return $this;
    }

    public function getImageProd(): ?string
    {
        return $this->image_prod;
    }

    public function setImageProd(string $image_prod): self
    {
        $this->image_prod = $image_prod;

        return $this;
    }

    public function getValidProd(): ?bool
    {
        return $this->valid_prod;
    }

    public function setValidProd(bool $valid_prod): self
    {
        $this->valid_prod = $valid_prod;

        return $this;
    }

    /**
     * @return Collection|DetailCommande[]
     */
    public function getDetailCommandes(): Collection
    {
        return $this->detailCommandes;
    }

    public function addDetailCommande(DetailCommande $detailCommande): self
    {
        if (!$this->detailCommandes->contains($detailCommande)) {
            $this->detailCommandes[] = $detailCommande;
            $detailCommande->setProduit($this);
        }

        return $this;
    }

    public function removeDetailCommande(DetailCommande $detailCommande): self
    {
        if ($this->detailCommandes->removeElement($detailCommande)) {
            // set the owning side to null (unless already changed)
            if ($detailCommande->getProduit() === $this) {
                $detailCommande->setProduit(null);
            }
        }

        return $this;
    }
}
