<?php

namespace App\Entity;

use App\Repository\ProduitsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProduitsRepository::class)
 */
class Produits
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $nomFournisseur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $nomRayon;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $description;

    /**
     * @ORM\Column(type="float")
     */
    private ?float $prVenteTTC;

    /**
     * @ORM\Column(type="float")
     */
    private ?float $prAchatBrutHT;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $origine;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $nomProduit;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $imageProduit;

    // Getters and setters for the properties...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFournisseur(): ?string
    {
        return $this->nomFournisseur;
    }

    public function setNomFournisseur(?string $nomFournisseur): self
    {
        $this->nomFournisseur = $nomFournisseur;
        return $this;
    }

    public function getNomRayon(): ?string
    {
        return $this->nomRayon;
    }

    public function setNomRayon(string $nomRayon): self
    {
        $this->nomRayon = $nomRayon;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getPrVenteTTC(): ?float
    {
        return $this->prVenteTTC;
    }

    public function setPrVenteTTC(float $prVenteTTC): self
    {
        $this->prVenteTTC = $prVenteTTC;
        return $this;
    }

    public function getPrAchatBrutHT(): ?float
    {
        return $this->prAchatBrutHT;
    }

    public function setPrAchatBrutHT(float $prAchatBrutHT): self
    {
        $this->prAchatBrutHT = $prAchatBrutHT;
        return $this;
    }

    public function getOrigine(): ?string
    {
        return $this->origine;
    }

    public function setOrigine(string $origine): self
    {
        $this->origine = $origine;
        return $this;
    }

    public function getNomProduit(): ?string
    {
        return $this->nomProduit;
    }

    public function setNomProduit(string $nomProduit): self
    {
        $this->nomProduit = $nomProduit;
        return $this;
    }

    public function getImageProduit(): ?string
    {
        return $this->imageProduit;
    }

    public function setImageProduit(?string $imageProduit): self
    {
        $this->imageProduit = $imageProduit;
        return $this;
    }
    public function __toString()
{
    return $this->nomProduit; 
}
}
