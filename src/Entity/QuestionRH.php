<?php

namespace App\Entity;

use App\Repository\QuestionRHRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRHRepository::class)]
class QuestionRH
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'questionRHs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?QuestionPour $questionPour = null;

    #[ORM\ManyToOne(inversedBy: 'questionRHs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Service $service = null;

    #[ORM\Column(length: 25)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $question = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $faitLe = null;

    #[ORM\ManyToOne(inversedBy: 'questionRHs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $demandeur = null;

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

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): static
    {
        $this->question = strip_tags($question);

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

    public function getQuestionPour(): ?QuestionPour
    {
        return $this->questionPour;
    }

    public function setQuestionPour(?QuestionPour $questionPour): static
    {
        $this->questionPour = $questionPour;

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
