<?php

namespace App\DTO;
use Symfony\Component\Validator\Constraints as Assert;

class AddressDTO
{
    private ?int $id = null;
    #[Assert\Valid]
    private GPSDTO $gps;
    private ?int $num = null;
    private ?string $voie = null;
    #[Assert\Regex(pattern: "/^\d{5}$/", message:"Le code postal doit contenir exactement 5 chiffres.")]
    private ?int $code_postale = null;
    #[Assert\NotNull]
    #[Assert\NotBlank]
     private ?string $ville = null;

    public function __construct() {}

    public function setGps(GPSDTO $gps): AddressDTO
    {
        $this->gps = $gps;
        return $this;
    }

    public function getGps(): GPSDTO
    {
        return $this->gps;
    }

    public function getNum(): ?int
    {
        return $this->num;
    }

    public function setNum(?int $num): AddressDTO
    {
        $this->num = $num;
        return $this;
    }

    public function getVoie(): ?string
    {
        return $this->voie;
    }

    public function setVoie(?string $voie): AddressDTO
    {
        $this->voie = $voie;
        return $this;
    }

    public function getCodePostale(): ?int
    {
        return $this->code_postale;
    }

    public function setCodePostale(?int $code_postale): AddressDTO
    {
        $this->code_postale = $code_postale;
        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): AddressDTO
    {
        $this->ville = $ville;
        return $this;
    }

    public function setId(?int $id): AddressDTO
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }


}