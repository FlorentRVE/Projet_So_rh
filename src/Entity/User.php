<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'demandeur', targetEntity: AttestationEmployeur::class)]
    private Collection $attestationEmployeurs;

    #[ORM\OneToMany(mappedBy: 'demandeur', targetEntity: ChangementAdresse::class)]
    private Collection $changementAdresses;

    #[ORM\OneToMany(mappedBy: 'demandeur', targetEntity: ChangementCompte::class)]
    private Collection $changementComptes;

    #[ORM\OneToMany(mappedBy: 'demandeur', targetEntity: DemandeAccompte::class)]
    private Collection $demandeAccomptes;

    #[ORM\OneToMany(mappedBy: 'demandeur', targetEntity: DemandeBulletinSalaire::class)]
    private Collection $demandeBulletinSalaires;

    #[ORM\OneToMany(mappedBy: 'demandeur', targetEntity: QuestionRH::class)]
    private Collection $questionRHs;

    #[ORM\OneToMany(mappedBy: 'demandeur', targetEntity: RendezVousRH::class)]
    private Collection $rendezVousRHs;

    public function __construct()
    {
        $this->attestationEmployeurs = new ArrayCollection();
        $this->changementAdresses = new ArrayCollection();
        $this->changementComptes = new ArrayCollection();
        $this->demandeAccomptes = new ArrayCollection();
        $this->demandeBulletinSalaires = new ArrayCollection();
        $this->questionRHs = new ArrayCollection();
        $this->rendezVousRHs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->username;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $attestationEmployeur->setDemandeur($this);
        }

        return $this;
    }

    public function removeAttestationEmployeur(AttestationEmployeur $attestationEmployeur): static
    {
        if ($this->attestationEmployeurs->removeElement($attestationEmployeur)) {
            // set the owning side to null (unless already changed)
            if ($attestationEmployeur->getDemandeur() === $this) {
                $attestationEmployeur->setDemandeur(null);
            }
        }

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
            $changementAdress->setDemandeur($this);
        }

        return $this;
    }

    public function removeChangementAdress(ChangementAdresse $changementAdress): static
    {
        if ($this->changementAdresses->removeElement($changementAdress)) {
            // set the owning side to null (unless already changed)
            if ($changementAdress->getDemandeur() === $this) {
                $changementAdress->setDemandeur(null);
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
            $changementCompte->setDemandeur($this);
        }

        return $this;
    }

    public function removeChangementCompte(ChangementCompte $changementCompte): static
    {
        if ($this->changementComptes->removeElement($changementCompte)) {
            // set the owning side to null (unless already changed)
            if ($changementCompte->getDemandeur() === $this) {
                $changementCompte->setDemandeur(null);
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
            $demandeAccompte->setDemandeur($this);
        }

        return $this;
    }

    public function removeDemandeAccompte(DemandeAccompte $demandeAccompte): static
    {
        if ($this->demandeAccomptes->removeElement($demandeAccompte)) {
            // set the owning side to null (unless already changed)
            if ($demandeAccompte->getDemandeur() === $this) {
                $demandeAccompte->setDemandeur(null);
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
            $demandeBulletinSalaire->setDemandeur($this);
        }

        return $this;
    }

    public function removeDemandeBulletinSalaire(DemandeBulletinSalaire $demandeBulletinSalaire): static
    {
        if ($this->demandeBulletinSalaires->removeElement($demandeBulletinSalaire)) {
            // set the owning side to null (unless already changed)
            if ($demandeBulletinSalaire->getDemandeur() === $this) {
                $demandeBulletinSalaire->setDemandeur(null);
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
            $questionRH->setDemandeur($this);
        }

        return $this;
    }

    public function removeQuestionRH(QuestionRH $questionRH): static
    {
        if ($this->questionRHs->removeElement($questionRH)) {
            // set the owning side to null (unless already changed)
            if ($questionRH->getDemandeur() === $this) {
                $questionRH->setDemandeur(null);
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
            $rendezVousRH->setDemandeur($this);
        }

        return $this;
    }

    public function removeRendezVousRH(RendezVousRH $rendezVousRH): static
    {
        if ($this->rendezVousRHs->removeElement($rendezVousRH)) {
            // set the owning side to null (unless already changed)
            if ($rendezVousRH->getDemandeur() === $this) {
                $rendezVousRH->setDemandeur(null);
            }
        }

        return $this;
    }
}
