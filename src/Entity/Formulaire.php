<?php

namespace App\Entity;

use App\Repository\FormulaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormulaireRepository::class)]
class Formulaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\OneToMany(mappedBy: 'formulaire', targetEntity: Champs::class)]
    private Collection $champs;

    public function __toString()
    {
        return $this->label;
    }

    public function __construct()
    {
        $this->champs = new ArrayCollection();
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
     * @return Collection<int, Champs>
     */
    public function getChamps(): Collection
    {
        return $this->champs;
    }

    public function addChamp(Champs $champ): static
    {
        if (!$this->champs->contains($champ)) {
            $this->champs->add($champ);
            $champ->setFormulaire($this);
        }

        return $this;
    }

    public function removeChamp(Champs $champ): static
    {
        if ($this->champs->removeElement($champ)) {
            // set the owning side to null (unless already changed)
            if ($champ->getFormulaire() === $this) {
                $champ->setFormulaire(null);
            }
        }

        return $this;
    }
}
