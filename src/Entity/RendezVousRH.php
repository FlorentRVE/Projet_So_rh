<?php

namespace App\Entity;

use App\Repository\RendezVousRHRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RendezVousRHRepository::class)]
class RendezVousRH
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'rendezVousRHs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?RdvAvec $rdvAvec = null;

    #[ORM\ManyToOne(inversedBy: 'rendezVousRHs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Service $service = null;

    #[ORM\Column(length: 25)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $message = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $faitLe = null;

    #[ORM\ManyToOne(inversedBy: 'rendezVousRHs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $demandeur = null;

    public function __toString() {
        return $this->service->getLabel();

    }
    public function getId(): ?int
    {
        return $this->id;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = strip_tags($message);

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

    public function getRdvAvec(): ?RdvAvec
    {
        return $this->rdvAvec;
    }

    public function setRdvAvec(?RdvAvec $rdvAvec): static
    {
        $this->rdvAvec = $rdvAvec;

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
