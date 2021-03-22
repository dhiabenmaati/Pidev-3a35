<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
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
    private $id_prod;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_prod;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $desc_prod;

    /**
     * @ORM\Column(type="integer")
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
     * @ORM\Column(type="integer")
     */
    private $valid_prod;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_ven;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_cat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdProd(): ?int
    {
        return $this->id_prod;
    }

    public function setIdProd(int $id_prod): self
    {
        $this->id_prod = $id_prod;

        return $this;
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

    public function getPrixProd(): ?int
    {
        return $this->prix_prod;
    }

    public function setPrixProd(int $prix_prod): self
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

    public function getValidProd(): ?int
    {
        return $this->valid_prod;
    }

    public function setValidProd(int $valid_prod): self
    {
        $this->valid_prod = $valid_prod;

        return $this;
    }

    public function getIdVen(): ?int
    {
        return $this->id_ven;
    }

    public function setIdVen(int $id_ven): self
    {
        $this->id_ven = $id_ven;

        return $this;
    }

    public function getIdCat(): ?int
    {
        return $this->id_cat;
    }

    public function setIdCat(int $id_cat): self
    {
        $this->id_cat = $id_cat;

        return $this;
    }
}
