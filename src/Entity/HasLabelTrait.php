<?php 

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

trait HasLabelTrait {

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    public function __toString()
    {
        return $this->label;
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

}