<?php

namespace App\Entity;

use App\Repository\EnchereRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnchereRepository::class)
 */
class Enchere
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_ench;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_prod;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $desc_prod;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image_prod;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_ench;

    /**
     * @ORM\Column(type="datetime")
     */
    private $valid_ench;

    /**
     * @ORM\Column(type="time")
     */
    private $duree_ench;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_ven;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdEnch(): ?int
    {
        return $this->id_ench;
    }

    public function setIdEnch(int $id_ench): self
    {
        $this->id_ench = $id_ench;

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

    public function setDescProd(?string $desc_prod): self
    {
        $this->desc_prod = $desc_prod;

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

    public function getDateEnch(): ?\DateTimeInterface
    {
        return $this->date_ench;
    }

    public function setDateEnch(\DateTimeInterface $date_ench): self
    {
        $this->date_ench = $date_ench;

        return $this;
    }

    public function getValidEnch(): ?\DateTimeInterface
    {
        return $this->valid_ench;
    }

    public function setValidEnch(\DateTimeInterface $valid_ench): self
    {
        $this->valid_ench = $valid_ench;

        return $this;
    }

    public function getDureeEnch(): ?\DateTimeInterface
    {
        return $this->duree_ench;
    }

    public function setDureeEnch(\DateTimeInterface $duree_ench): self
    {
        $this->duree_ench = $duree_ench;

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
}
