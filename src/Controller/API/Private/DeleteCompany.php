<?php

namespace App\Controller\API\Private;

use App\Entity\Company;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteCompany extends AbstractController
{
    const ROUTE_NAME = 'api_open_delete_company';

    #[Route('/api-protege/{siren}', name: self::ROUTE_NAME, methods: [Request::METHOD_DELETE])]
    #[ParamConverter('company', options: ['mapping' => ['siren' => 'siren']])]
    public function __invoke(Company $company, EntityManagerInterface $em)
    {
        $em->remove($company);
        $em->flush();

        return new Response();
    }
}