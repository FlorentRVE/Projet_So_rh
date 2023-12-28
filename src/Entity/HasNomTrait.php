<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait HasNomTrait
{
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $prenom = null;

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }
}
