<?php

namespace App\DTO;

class GPSDTO
{
    private ?string $longitude = null;
    private ?string $latitude = null;

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): GPSDTO
    {
        $this->longitude = $longitude;
        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): GPSDTO
    {
        $this->latitude = $latitude;
        return $this;
    }
}