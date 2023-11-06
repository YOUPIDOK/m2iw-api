<?php

namespace App\DTO;

use Symfony\Component\Serializer\Annotation\SerializedName;

class Address
{
    #[SerializedName('adresse')]
    private string $address;

    private string $siret;

    public function setAddress(string $address): Address
    {
        $this->address = $address;
        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setSiret(string $siret): Address
    {
        $this->siret = $siret;
        return $this;
    }

    public function getSiret(): string
    {
        return $this->siret;
    }
}