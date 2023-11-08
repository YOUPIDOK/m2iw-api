<?php

namespace App\Entity;

use App\DTO\AddressDTO;
use App\DTO\CompanyDTO;
use App\DTO\GPSDTO;
use App\Repository\CompanyRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\UniqueConstraint(fields: ['siren'])]
#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[SerializedName('nom_raison_sociale')]
    private ?string $name = null;

    #[ORM\Column(length: 10)]
    private ?string $siren = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Address $siege = null;

    #[ORM\Column]
    #[Ignore]
    private ?bool $current = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSiren(): ?string
    {
        return $this->siren;
    }

    public function setSiren(string $siren): static
    {
        $this->siren = $siren;

        return $this;
    }

    public function getSiege(): ?Address
    {
        return $this->siege;
    }

    public function setSiege(Address $siege): static
    {
        $this->siege = $siege;

        return $this;
    }

    public function isCurrent(): ?bool
    {
        return $this->current;
    }

    public function setCurrent(bool $current): static
    {
        $this->current = $current;

        return $this;
    }

    public function toDTO(): CompanyDTO
    {
        $address = new AddressDTO();
        $siege = $this->siege;

        $gps = new GPSDTO();
        $gps->setLongitude($siege->getLongitude());
        $gps->setLatitude($siege->getLatitude());

        $address->setId($siege->getId());
        $address->setGps($gps);
        $address->setNum($siege->getNum());
        $address->setVille($siege->getTown());
        $address->setVoie($siege->getRoute());
        $address->setCodePostale($siege->getPostalCode());

        $company = new CompanyDTO();
        $company->setId($this->id);
        $company->setAdresse($address);
        $company->setSiren($this->siren);
        $company->setRaisonSociale($this->name);

        return $company;
    }

    public function setId(?int $id): Company
    {
        $this->id = $id;
        return $this;
    }
}
