<?php

namespace App\DTO;

use App\Entity\Address;
use App\Entity\Company;
use Symfony\Component\Validator\Constraints as Assert;

class CompanyDTO
{
    private ?int $id = null;

    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Length(min: 9, max: 9)]
    private ?int $siren = null;

    #[Assert\NotNull]
    #[Assert\NotBlank]
    private ?string $raison_sociale = null;

    #[Assert\Valid]
    private ?AddressDTO $adresse = null;

    public function __construct() {}

    public function setSiren(?int $siren): CompanyDTO
    {
        $this->siren = $siren;
        return $this;
    }

    public function getSiren(): ?int
    {
        return $this->siren;
    }

    public function setRaisonSociale(?string $raison_sociale): CompanyDTO
    {
        $this->raison_sociale = $raison_sociale;
        return $this;
    }

    public function getRaisonSociale(): ?string
    {
        return $this->raison_sociale;
    }

    public function getAdresse(): ?AddressDTO
    {
        return $this->adresse;
    }

    public function setAdresse(?AddressDTO $adresse): CompanyDTO
    {
        $this->adresse = $adresse;
        return $this;
    }

    public function toCompany(): Company
    {
        $address = $this->getAdresse();

        $siege = new Address();
        $siege->setId($address?->getId());
        $siege->setAddress($address?->getNum() . ' ' . $address?->getVoie() . '(' . $address?->getCodePostale() . ') ' . $address?->getVille());
        $siege->setNum($address?->getNum());
        $siege->setLatitude($address?->getGps()?->getLatitude());
        $siege->setLongitude($address?->getGps()?->getLongitude());
        $siege->setRoute($address?->getVoie());
        $siege->setPostalCode($address?->getCodePostale());
        $siege->setTown($address?->getVille());

        $company = new Company();
        $company->setId($this->id);
        $company->setName($this->raison_sociale);
        $company->setSiren($this->siren);
        $company->setSiege($siege);

        return $company;
    }

    public function setId(?int $id): CompanyDTO
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}