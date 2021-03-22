<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id_cat;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_cat;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNomCat(): ?string
    {
        return $this->nom_cat;
    }

    public function setNomCat(string $nom_cat): self
    {
        $this->nom_cat = $nom_cat;

        return $this;
    }
}
