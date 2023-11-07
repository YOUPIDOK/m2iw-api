<?php

namespace App\DTO\UrsaffApi;

class MinSalaryInternship
{
    public function __construct(
        private float $minSalary
    ) { }

    public function getMinSalary(): float
    {
        return $this->minSalary;
    }

    public function setMinSalary(float $minSalary): self
    {
        $this->minSalary = $minSalary;

        return $this;
    }

}