<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
#[ORM\UniqueConstraint(fields: ['siret'])]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[SerializedName('adresse')]
    private ?string $address = null;

    #[SerializedName('numero_voie')]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $num = null;

    #[SerializedName('libelle_voie')]
    #[ORM\Column(length: 255)]
    private ?string $route = null;

    #[SerializedName('code_postal')]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $postalCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $siret = null;

    #[SerializedName('libelle_commune')]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $town = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $latitude = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $longitude = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(string $siret): static
    {
        $this->siret = $siret;

        return $this;
    }

    public function getNum(): ?string
    {
        return $this->num;
    }

    public function setNum(?string $num): Address
    {
        $this->num = $num;
        return $this;
    }

    public function getRoute(): ?string
    {
        return $this->route;
    }

    public function setRoute(?string $route): Address
    {
        $this->route = $route;
        return $this;
    }

    public function setPostalCode(?string $postalCode): Address
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setTown(?string $town): Address
    {
        $this->town = $town;
        return $this;
    }

    public function getTown(): ?string
    {
        return $this->town;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): Address
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): Address
    {
        $this->longitude = $longitude;
        return $this;
    }
}
