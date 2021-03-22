<?php

namespace App\Entity;

use App\Repository\ReponseReclamationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=ReponseReclamationRepository::class)
 */
class ReponseReclamation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Reclamation::class, cascade={"persist", "remove"})
     */
    private $id_rec;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $desc_reponse_rec;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdRec(): ?Reclamation
    {
        return $this->id_rec;
    }

    public function setIdRec(?Reclamation $id_rec): self
    {
        $this->id_rec = $id_rec;

        return $this;
    }

    public function getDescReponseRec(): ?string
    {
        return $this->desc_reponse_rec;
    }

    public function setDescReponseRec(string $desc_reponse_rec): self
    {
        $this->desc_reponse_rec = $desc_reponse_rec;

        return $this;
    }
}
