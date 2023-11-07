<?php

namespace App\Services;

use App\Controller\API\CompanyAPI;
use App\DTO\Company;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\SerializerInterface;

class CompanyService
{
    const COMPANY = 'COMPANY';
    const FILE_NAME = 'company.json';

    private string $filePath;

    public function __construct(
        private RequestStack $request,
        private SerializerInterface $serializer,
        ParameterBagInterface $parameterBag
    ) {
        $this->filePath = $parameterBag->get('kernel.project_dir') . '/var/' . self::FILE_NAME;
    }

    public function save(Company $company): void
    {
        $this->request->getSession()->set(self::COMPANY, $company);
        file_put_contents($this->filePath, $this->serializer->serialize($company, 'json'));
    }

    public function getCompany()
    {
        $company = $this->request->getSession()->get(self::COMPANY);

        if ($company === null && is_file($this->filePath)) {
            $company = $this->serializer->deserialize(file_get_contents($this->filePath), Company::class, 'json');
        }

        return $company;
    }
}