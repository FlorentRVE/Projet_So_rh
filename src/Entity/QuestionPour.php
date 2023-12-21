<?php

namespace App\Entity;

use App\Repository\QuestionPourRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionPourRepository::class)]
class QuestionPour
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\OneToMany(mappedBy: 'questionPour', targetEntity: QuestionRH::class)]
    private Collection $questionRHs;

    public function __construct()
    {
        $this->questionRHs = new ArrayCollection();
    }
    public function __toString()
    {
        return $this->label;
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
     * @return Collection<int, QuestionRH>
     */
    public function getQuestionRHs(): Collection
    {
        return $this->questionRHs;
    }

    public function addQuestionRH(QuestionRH $questionRH): static
    {
        if (!$this->questionRHs->contains($questionRH)) {
            $this->questionRHs->add($questionRH);
            $questionRH->setQuestionPour($this);
        }

        return $this;
    }

    public function removeQuestionRH(QuestionRH $questionRH): static
    {
        if ($this->questionRHs->removeElement($questionRH)) {
            // set the owning side to null (unless already changed)
            if ($questionRH->getQuestionPour() === $this) {
                $questionRH->setQuestionPour(null);
            }
        }

        return $this;
    }
}
