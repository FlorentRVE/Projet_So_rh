<?php

namespace App\Entity;

use App\Repository\BotCategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BotCategorieRepository::class)]
class BotCategorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: BotQuestion::class)]
    private Collection $botQuestions;

    public function __construct()
    {
        $this->botQuestions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, BotQuestion>
     */
    public function getBotQuestions(): Collection
    {
        return $this->botQuestions;
    }

    public function addBotQuestion(BotQuestion $botQuestion): static
    {
        if (!$this->botQuestions->contains($botQuestion)) {
            $this->botQuestions->add($botQuestion);
            $botQuestion->setCategorie($this);
        }

        return $this;
    }

    public function removeBotQuestion(BotQuestion $botQuestion): static
    {
        if ($this->botQuestions->removeElement($botQuestion)) {
            // set the owning side to null (unless already changed)
            if ($botQuestion->getCategorie() === $this) {
                $botQuestion->setCategorie(null);
            }
        }

        return $this;
    }
}
