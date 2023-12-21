<?php

namespace App\Entity;

use App\Repository\RdvAvecRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RdvAvecRepository::class)]
class RdvAvec
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\OneToMany(mappedBy: 'rdvAvec', targetEntity: RendezVousRH::class)]
    private Collection $rendezVousRHs;

    public function __construct()
    {
        $this->rendezVousRHs = new ArrayCollection();
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
     * @return Collection<int, RendezVousRH>
     */
    public function getRendezVousRHs(): Collection
    {
        return $this->rendezVousRHs;
    }

    public function addRendezVousRH(RendezVousRH $rendezVousRH): static
    {
        if (!$this->rendezVousRHs->contains($rendezVousRH)) {
            $this->rendezVousRHs->add($rendezVousRH);
            $rendezVousRH->setRdvAvec($this);
        }

        return $this;
    }

    public function removeRendezVousRH(RendezVousRH $rendezVousRH): static
    {
        if ($this->rendezVousRHs->removeElement($rendezVousRH)) {
            // set the owning side to null (unless already changed)
            if ($rendezVousRH->getRdvAvec() === $this) {
                $rendezVousRH->setRdvAvec(null);
            }
        }

        return $this;
    }
}
