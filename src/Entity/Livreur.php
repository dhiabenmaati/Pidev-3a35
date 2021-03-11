<?php

namespace App\Entity;

use App\Repository\LivreurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LivreurRepository::class)
 */
class Livreur
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
    private $nom_livreur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom_livreur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email_livreur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mdp_livreur;

    /**
     * @ORM\Column(type="integer")
     */
    private $num_livreur;

    /**
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="livreur")
     */
    private $commandes;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomLivreur(): ?string
    {
        return $this->nom_livreur;
    }

    public function setNomLivreur(string $nom_livreur): self
    {
        $this->nom_livreur = $nom_livreur;

        return $this;
    }

    public function getPrenomLivreur(): ?string
    {
        return $this->prenom_livreur;
    }

    public function setPrenomLivreur(string $prenom_livreur): self
    {
        $this->prenom_livreur = $prenom_livreur;

        return $this;
    }

    public function getEmailLivreur(): ?string
    {
        return $this->email_livreur;
    }

    public function setEmailLivreur(string $email_livreur): self
    {
        $this->email_livreur = $email_livreur;

        return $this;
    }

    public function getMdpLivreur(): ?string
    {
        return $this->mdp_livreur;
    }

    public function setMdpLivreur(string $mdp_livreur): self
    {
        $this->mdp_livreur = $mdp_livreur;

        return $this;
    }

    public function getNumLivreur(): ?int
    {
        return $this->num_livreur;
    }

    public function setNumLivreur(int $num_livreur): self
    {
        $this->num_livreur = $num_livreur;

        return $this;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setLivreur($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getLivreur() === $this) {
                $commande->setLivreur(null);
            }
        }

        return $this;
    }
}
