<?php

namespace App\Services;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;

class CompanyService
{
    public function __construct(private CompanyRepository $companyRepository, private EntityManagerInterface $em) {}

    public function save(Company $company): void
    {
        foreach ($this->companyRepository->findBy(['current' => true]) as $company){
            $company->setCurrent(false);
        }
        $this->em->flush();

        $company->setCurrent(true);
        $this->em->persist($company);
        $this->em->flush();
    }

    public function getCompany()
    {
        return $this->companyRepository->findOneBy(['current' => true]);
    }


}