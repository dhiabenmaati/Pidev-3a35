<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvenementRepository::class)
 */
class Evenement
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $in_event;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_event;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $desc_event;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_event;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInEvent(): ?int
    {
        return $this->in_event;
    }

    public function setInEvent(int $in_event): self
    {
        $this->in_event = $in_event;

        return $this;
    }

    public function getNomEvent(): ?string
    {
        return $this->nom_event;
    }

    public function setNomEvent(string $nom_event): self
    {
        $this->nom_event = $nom_event;

        return $this;
    }

    public function getDescEvent(): ?string
    {
        return $this->desc_event;
    }

    public function setDescEvent(string $desc_event): self
    {
        $this->desc_event = $desc_event;

        return $this;
    }

    public function getImageEvent(): ?string
    {
        return $this->image_event;
    }

    public function setImageEvent(?string $image_event): self
    {
        $this->image_event = $image_event;

        return $this;
    }
}
