<?php

namespace App\Entity;

use App\Repository\OrdresRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrdresRepository::class)
 */
class Ordres
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id_ordre;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_cree;

    /**
     * @ORM\Column(type="integer")
     */
    private $date_expedirer;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_clt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdOrdre(): ?int
    {
        return $this->id_ordre;
    }

    public function setIdOrdre(int $id_ordre): self
    {
        $this->id_ordre = $id_ordre;

        return $this;
    }

    public function getDateCree(): ?\DateTimeInterface
    {
        return $this->date_cree;
    }

    public function setDateCree(\DateTimeInterface $date_cree): self
    {
        $this->date_cree = $date_cree;

        return $this;
    }

    public function getDateExpedirer(): ?int
    {
        return $this->date_expedirer;
    }

    public function setDateExpedirer(int $date_expedirer): self
    {
        $this->date_expedirer = $date_expedirer;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

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
}
