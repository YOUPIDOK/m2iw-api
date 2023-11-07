<?php

namespace App\DTO\UrsaffApi;

class NetSalaryCDD
{
    public function __construct(
        private float $netSalaryBeforeTax ,
        private float $employeeContributions,
        private float $employerCosts,
        private float $severancePay,
    ) { }

    public function getNetSalaryBeforeTax(): float
    {
        return $this->netSalaryBeforeTax;
    }

    public function setNetSalaryBeforeTax(float $netSalaryBeforeTax): void
    {
        $this->netSalaryBeforeTax = $netSalaryBeforeTax;
    }

    public function getEmployeeContributions(): float
    {
        return $this->employeeContributions;
    }

    public function setEmployeeContributions(float $employeeContributions): void
    {
        $this->employeeContributions = $employeeContributions;
    }

    public function getEmployerCosts(): float
    {
        return $this->employerCosts;
    }

    public function setEmployerCosts(float $employerCosts): void
    {
        $this->employerCosts = $employerCosts;
    }

    public function setSeverancePay(float $severancePay): NetSalaryCDD
    {
        $this->severancePay = $severancePay;
        return $this;
    }

    public function getSeverancePay(): float
    {
        return $this->severancePay;
    }
}