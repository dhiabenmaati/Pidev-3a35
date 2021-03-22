<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=ReviewRepository::class)
 */
class Review
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id_rev;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $id_clt;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $id_prod;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="champ commentaire vide")
     */
    private $commentaire;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $note;

    /**
     * @var date $date
     *
     * @ORM\Column(name="date", type="datetime")
     * @ORM\Version
     *
     */
    private $created_at;


    public function getIdRev(): ?int
    {
        return $this->id_rev;
    }

    public function setIdRev(int $id_rev): self
    {
        $this->id_rev = $id_rev;

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

    public function getIdProd(): ?int
    {
        return $this->id_prod;
    }

    public function setIdProd(int $id_prod): self
    {
        $this->id_prod = $id_prod;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
