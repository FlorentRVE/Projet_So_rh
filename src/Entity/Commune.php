<?php

namespace App\Entity;

use App\Repository\CommuneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommuneRepository::class)]
class Commune
{
    use HasLabelTrait;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $codePostal = null;

    #[ORM\OneToMany(mappedBy: 'commune', targetEntity: ChangementAdresse::class)]
    private Collection $changementAdresses;

    #[ORM\OneToMany(mappedBy: 'faitA', targetEntity: ChangementAdresse::class)]
    private Collection $faitA;

    #[ORM\OneToMany(mappedBy: 'faitA', targetEntity: DemandeAccompte::class)]
    private Collection $demandeAccomptes;

    #[ORM\OneToMany(mappedBy: 'faitA', targetEntity: DemandeBulletinSalaire::class)]
    private Collection $demandeBulletinSalaires;

    #[ORM\OneToMany(mappedBy: 'faitA', targetEntity: ChangementCompte::class)]
    private Collection $changementComptes;

    public function __construct()
    {
        $this->changementAdresses = new ArrayCollection();
        $this->faitA = new ArrayCollection();
        $this->demandeAccomptes = new ArrayCollection();
        $this->demandeBulletinSalaires = new ArrayCollection();
        $this->changementComptes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodePostal(): ?int
    {
        return $this->codePostal;
    }

    public function setCodePostal(int $codePostal): static
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * @return Collection<int, ChangementAdresse>
     */
    public function getChangementAdresses(): Collection
    {
        return $this->changementAdresses;
    }

    public function addChangementAdress(ChangementAdresse $changementAdress): static
    {
        if (!$this->changementAdresses->contains($changementAdress)) {
            $this->changementAdresses->add($changementAdress);
            $changementAdress->setCommune($this);
        }

        return $this;
    }

    public function removeChangementAdress(ChangementAdresse $changementAdress): static
    {
        if ($this->changementAdresses->removeElement($changementAdress)) {
            // set the owning side to null (unless already changed)
            if ($changementAdress->getCommune() === $this) {
                $changementAdress->setCommune(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ChangementAdresse>
     */
    public function getFaitA(): Collection
    {
        return $this->faitA;
    }

    public function addFaitA(ChangementAdresse $faitA): static
    {
        if (!$this->faitA->contains($faitA)) {
            $this->faitA->add($faitA);
            $faitA->setFaitA($this);
        }

        return $this;
    }

    public function removeFaitA(ChangementAdresse $faitA): static
    {
        if ($this->faitA->removeElement($faitA)) {
            // set the owning side to null (unless already changed)
            if ($faitA->getFaitA() === $this) {
                $faitA->setFaitA(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DemandeAccompte>
     */
    public function getDemandeAccomptes(): Collection
    {
        return $this->demandeAccomptes;
    }

    public function addDemandeAccompte(DemandeAccompte $demandeAccompte): static
    {
        if (!$this->demandeAccomptes->contains($demandeAccompte)) {
            $this->demandeAccomptes->add($demandeAccompte);
            $demandeAccompte->setFaitA($this);
        }

        return $this;
    }

    public function removeDemandeAccompte(DemandeAccompte $demandeAccompte): static
    {
        if ($this->demandeAccomptes->removeElement($demandeAccompte)) {
            // set the owning side to null (unless already changed)
            if ($demandeAccompte->getFaitA() === $this) {
                $demandeAccompte->setFaitA(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DemandeBulletinSalaire>
     */
    public function getDemandeBulletinSalaires(): Collection
    {
        return $this->demandeBulletinSalaires;
    }

    public function addDemandeBulletinSalaire(DemandeBulletinSalaire $demandeBulletinSalaire): static
    {
        if (!$this->demandeBulletinSalaires->contains($demandeBulletinSalaire)) {
            $this->demandeBulletinSalaires->add($demandeBulletinSalaire);
            $demandeBulletinSalaire->setFaitA($this);
        }

        return $this;
    }

    public function removeDemandeBulletinSalaire(DemandeBulletinSalaire $demandeBulletinSalaire): static
    {
        if ($this->demandeBulletinSalaires->removeElement($demandeBulletinSalaire)) {
            // set the owning side to null (unless already changed)
            if ($demandeBulletinSalaire->getFaitA() === $this) {
                $demandeBulletinSalaire->setFaitA(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ChangementCompte>
     */
    public function getChangementComptes(): Collection
    {
        return $this->changementComptes;
    }

    public function addChangementCompte(ChangementCompte $changementCompte): static
    {
        if (!$this->changementComptes->contains($changementCompte)) {
            $this->changementComptes->add($changementCompte);
            $changementCompte->setFaitA($this);
        }

        return $this;
    }

    public function removeChangementCompte(ChangementCompte $changementCompte): static
    {
        if ($this->changementComptes->removeElement($changementCompte)) {
            // set the owning side to null (unless already changed)
            if ($changementCompte->getFaitA() === $this) {
                $changementCompte->setFaitA(null);
            }
        }

        return $this;
    }
}
