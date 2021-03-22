<?php

namespace App\Entity;

use App\Repository\EnchereEncoursRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnchereEncoursRepository::class)
 */
class EnchereEncours
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id_ench_encours;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_ench;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_clt;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdEnchEncours(): ?int
    {
        return $this->id_ench_encours;
    }

    public function setIdEnchEncours(int $id_ench_encours): self
    {
        $this->id_ench_encours = $id_ench_encours;

        return $this;
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

    public function getIdClt(): ?int
    {
        return $this->id_clt;
    }

    public function setIdClt(int $id_clt): self
    {
        $this->id_clt = $id_clt;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
}
