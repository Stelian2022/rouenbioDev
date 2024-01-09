<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use App\Repository\FideliteRepository;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=FideliteRepository::class)
 */
class Fidelite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(length=255)
     */
    private ?string $Nom = null;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private ?string $mtFidelite = null;

    /**
     * @ORM\Column(name="mt_fidelite_utilise", type="decimal", precision=10, scale=2)
     */
    private ?string $MtFidelitéUtilisé = null;


    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="fidelite")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private ?User $user;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }
    public function getUsers():?User
    {
        return $this->user;
    }
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }


    public function getMtFidelite(): ?int
    {
        return $this->mtFidelite;
    }

    public function setMtFidelite(string $mtFidelite): self
    {
        $this->mtFidelite = $mtFidelite;

        return $this;
    }

    public function getMtFidelitéUtilisé(): ?string
    {
        return $this->MtFidelitéUtilisé;
    }

    public function setMtFidelitéUtilisé(string $MtFidelitéUtilisé): self
    {
        $this->MtFidelitéUtilisé = $MtFidelitéUtilisé;

        return $this;
    }
}
