<?php

namespace App\Entity;

use App\Repository\BotQuestionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BotQuestionRepository::class)]
class BotQuestion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $question = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $reponse = null;

    #[ORM\ManyToOne(inversedBy: 'botQuestions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BotCategorie $categorie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(string $reponse): static
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function getCategorie(): ?BotCategorie
    {
        return $this->categorie;
    }

    public function setCategorie(?BotCategorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }
}
