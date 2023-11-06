<?php

namespace App\Services;

use App\Controller\API\CompanyAPI;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class CompanyService
{
    const COMPANY = 'COMPANY';
    const FILE_NAME = 'company.json';

    public function __construct(
        private RequestStack $request,
        private ParameterBagInterface $parameterBag
    ) { }

    /**
     * Save data in session and txt
     * @param string $siren
     * @return void
     */
    public function save(array $company): void
    {
        $this->request->getSession()->set(self::COMPANY, $company);

        $filePath = $this->parameterBag->get('kernel.project_dir') . '/var/' . self::FILE_NAME;

        file_put_contents($filePath, json_encode($company));
    }
}