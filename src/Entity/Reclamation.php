<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=ReclamationRepository::class)
 */
class Reclamation
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="champ descrption vide")
     */
    private $desc_rec;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $id_clt;


    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $status_rec;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $progress_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $valid_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $reclamation_at;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescRec(): ?string
    {
        return $this->desc_rec;
    }

    public function setDescRec(string $desc_rec): self
    {
        $this->desc_rec = $desc_rec;

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

    public function getStatusRec(): ?string
    {
        return $this->status_rec;
    }

    public function setStatusRec(string $status_rec): self
    {
        $this->status_rec = $status_rec;

        return $this;
    }

    public function getProgressAt(): ?\DateTimeInterface
    {
        return $this->progress_at;
    }

    public function setProgressAt(?\DateTimeInterface $progress_at): self
    {
        $this->progress_at = $progress_at;

        return $this;
    }

    public function getValidAt(): ?\DateTimeInterface
    {
        return $this->valid_at;
    }

    public function setValidAt(?\DateTimeInterface $valid_at): self
    {
        $this->valid_at = $valid_at;

        return $this;
    }

    public function getReclamationAt(): ?\DateTimeInterface
    {
        return $this->reclamation_at;
    }

    public function setReclamationAt(?\DateTimeInterface $reclamation_at): self
    {
        $this->reclamation_at = $reclamation_at;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
