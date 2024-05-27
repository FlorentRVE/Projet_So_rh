<?php

namespace App\Entity;

use App\Repository\AttestationEmployeurRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttestationEmployeurRepository::class)]
class AttestationEmployeur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 25)]
    private ?string $telephone = null;

    #[ORM\ManyToOne(inversedBy: 'attestationEmployeurs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Service $service = null;

    #[ORM\Column(length: 255)]
    private ?string $fonction = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $motif = null;

    #[ORM\Column(length: 255)]
    private ?string $recuperation = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $faitLe = null;

    #[ORM\ManyToOne(inversedBy: 'attestationEmployeurs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $demandeur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

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

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(?string $motif): static
    {
        $this->motif = $motif;

        return $this;
    }

    public function getRecuperation(): ?string
    {
        return $this->recuperation;
    }

    public function setRecuperation(string $recuperation): static
    {
        $this->recuperation = $recuperation;

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

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): static
    {
        $this->service = $service;

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
