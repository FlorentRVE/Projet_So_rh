<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    use HasLabelTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: ChangementAdresse::class)]
    private Collection $changementAdresses;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: AttestationEmployeur::class)]
    private Collection $attestationEmployeurs;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: DemandeAccompte::class)]
    private Collection $demandeAccomptes;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: DemandeBulletinSalaire::class)]
    private Collection $demandeBulletinSalaires;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: QuestionRH::class)]
    private Collection $questionRHs;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: RendezVousRH::class)]
    private Collection $rendezVousRHs;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: ChangementCompte::class)]
    private Collection $changementComptes;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $emailSecretariat = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $emailResponsable = null;

    public function __construct()
    {
        $this->changementAdresses = new ArrayCollection();
        $this->attestationEmployeurs = new ArrayCollection();
        $this->demandeAccomptes = new ArrayCollection();
        $this->demandeBulletinSalaires = new ArrayCollection();
        $this->questionRHs = new ArrayCollection();
        $this->rendezVousRHs = new ArrayCollection();
        $this->changementComptes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $changementAdress->setService($this);
        }

        return $this;
    }

    public function removeChangementAdress(ChangementAdresse $changementAdress): static
    {
        if ($this->changementAdresses->removeElement($changementAdress)) {
            // set the owning side to null (unless already changed)
            if ($changementAdress->getService() === $this) {
                $changementAdress->setService(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AttestationEmployeur>
     */
    public function getAttestationEmployeurs(): Collection
    {
        return $this->attestationEmployeurs;
    }

    public function addAttestationEmployeur(AttestationEmployeur $attestationEmployeur): static
    {
        if (!$this->attestationEmployeurs->contains($attestationEmployeur)) {
            $this->attestationEmployeurs->add($attestationEmployeur);
            $attestationEmployeur->setService($this);
        }

        return $this;
    }

    public function removeAttestationEmployeur(AttestationEmployeur $attestationEmployeur): static
    {
        if ($this->attestationEmployeurs->removeElement($attestationEmployeur)) {
            // set the owning side to null (unless already changed)
            if ($attestationEmployeur->getService() === $this) {
                $attestationEmployeur->setService(null);
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
            $demandeAccompte->setService($this);
        }

        return $this;
    }

    public function removeDemandeAccompte(DemandeAccompte $demandeAccompte): static
    {
        if ($this->demandeAccomptes->removeElement($demandeAccompte)) {
            // set the owning side to null (unless already changed)
            if ($demandeAccompte->getService() === $this) {
                $demandeAccompte->setService(null);
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
            $demandeBulletinSalaire->setService($this);
        }

        return $this;
    }

    public function removeDemandeBulletinSalaire(DemandeBulletinSalaire $demandeBulletinSalaire): static
    {
        if ($this->demandeBulletinSalaires->removeElement($demandeBulletinSalaire)) {
            // set the owning side to null (unless already changed)
            if ($demandeBulletinSalaire->getService() === $this) {
                $demandeBulletinSalaire->setService(null);
            }
        }

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
            $questionRH->setService($this);
        }

        return $this;
    }

    public function removeQuestionRH(QuestionRH $questionRH): static
    {
        if ($this->questionRHs->removeElement($questionRH)) {
            // set the owning side to null (unless already changed)
            if ($questionRH->getService() === $this) {
                $questionRH->setService(null);
            }
        }

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
            $rendezVousRH->setService($this);
        }

        return $this;
    }

    public function removeRendezVousRH(RendezVousRH $rendezVousRH): static
    {
        if ($this->rendezVousRHs->removeElement($rendezVousRH)) {
            // set the owning side to null (unless already changed)
            if ($rendezVousRH->getService() === $this) {
                $rendezVousRH->setService(null);
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
            $changementCompte->setService($this);
        }

        return $this;
    }

    public function removeChangementCompte(ChangementCompte $changementCompte): static
    {
        if ($this->changementComptes->removeElement($changementCompte)) {
            // set the owning side to null (unless already changed)
            if ($changementCompte->getService() === $this) {
                $changementCompte->setService(null);
            }
        }

        return $this;
    }

    public function getEmailSecretariat(): ?string
    {
        return $this->emailSecretariat;
    }

    public function setEmailSecretariat(?string $emailSecretariat): static
    {
        $this->emailSecretariat = $emailSecretariat;

        return $this;
    }

    public function getEmailResponsable(): ?string
    {
        return $this->emailResponsable;
    }

    public function setEmailResponsable(?string $emailResponsable): static
    {
        $this->emailResponsable = $emailResponsable;

        return $this;
    }
}
