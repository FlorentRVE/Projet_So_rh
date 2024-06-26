<?php

namespace App\Entity;

use App\Repository\DemandeAccompteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandeAccompteRepository::class)]
class DemandeAccompte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'demandeAccomptes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Service $service = null;

    #[ORM\Column(length: 255)]
    private ?string $fonction = null;

    #[ORM\Column]
    private ?int $accompteChiffre = null;

    #[ORM\Column(length: 255)]
    private ?string $accompteLettre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $motif = null;

    #[ORM\ManyToOne(inversedBy: 'demandeAccomptes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Commune $faitA = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $faitLe = null;

    #[ORM\ManyToOne(inversedBy: 'demandeAccomptes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $demandeur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): static
    {
        $this->service = $service;

        return $this;
    }

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(string $fonction): static
    {
        $this->fonction = strip_tags($fonction);

        return $this;
    }

    public function getAccompteChiffre(): ?int
    {
        return $this->accompteChiffre;
    }

    public function setAccompteChiffre(int $accompteChiffre): static
    {
        $this->accompteChiffre = $accompteChiffre;

        return $this;
    }

    public function getAccompteLettre(): ?string
    {
        return $this->accompteLettre;
    }

    public function setAccompteLettre(string $accompteLettre): static
    {
        $this->accompteLettre = strip_tags($accompteLettre);

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(?string $motif): static
    {
        $this->motif = strip_tags($motif);

        return $this;
    }

    public function getFaitA(): ?Commune
    {
        return $this->faitA;
    }

    public function setFaitA(?Commune $faitA): static
    {
        $this->faitA = $faitA;

        return $this;
    }

    public function getFaitLe(): ?\DateTimeImmutable
    {
        return $this->faitLe;
    }

    public function setFaitLe(\DateTimeImmutable $faitLe): static
    {
        $this->faitLe = $faitLe;

        return $this;
    }

    public function getDemandeur(): ?User
    {
        return $this->demandeur;
    }

    public function setDemandeur(?User $demandeur): static
    {
        $this->demandeur = $demandeur;

        return $this;
    }
}
