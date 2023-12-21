<?php

namespace App\Entity;

use App\Repository\DemandeBulletinSalaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandeBulletinSalaireRepository::class)]
class DemandeBulletinSalaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column]
    private ?int $telephone = null;

    #[ORM\ManyToOne(inversedBy: 'demandeBulletinSalaires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Service $service = null;

    #[ORM\Column(length: 255)]
    private ?string $fonction = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateDu = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateAu = null;

    #[ORM\Column(length: 255)]
    private ?string $motif = null;

    #[ORM\Column(length: 255)]
    private ?string $recuperation = null;

    #[ORM\ManyToOne(inversedBy: 'demandeBulletinSalaires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Commune $faitA = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $faitLe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
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

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): static
    {
        $this->telephone = $telephone;

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

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(string $fonction): static
    {
        $this->fonction = $fonction;

        return $this;
    }

    public function getDateDu(): ?\DateTimeImmutable
    {
        return $this->dateDu;
    }

    public function setDateDu(\DateTimeImmutable $dateDu): static
    {
        $this->dateDu = $dateDu;

        return $this;
    }

    public function getDateAu(): ?\DateTimeImmutable
    {
        return $this->dateAu;
    }

    public function setDateAu(\DateTimeImmutable $dateAu): static
    {
        $this->dateAu = $dateAu;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(string $motif): static
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
}
