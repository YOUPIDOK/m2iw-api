<?php

namespace App\DTO;

use Symfony\Component\Serializer\Annotation\SerializedName;

class Company
{
    private string $siren;

    #[SerializedName('nom_raison_sociale')]
    private string $name;

    private Address $siege;

    public function getSiren(): string
    {
        return $this->siren;
    }

    public function setSiren(string $siren): self
    {
        $this->siren = $siren;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setSiege(Address $siege): Company
    {
        $this->siege = $siege;
        return $this;
    }

    public function getSiege(): Address
    {
        return $this->siege;
    }
}