<?php

namespace App\Controller\API\Public;

use App\Entity\Company;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GetCompanyController extends AbstractController
{
    const ROUTE_NAME = 'api_open_get_company';

    #[Route('/api-ouverte-ent/{siren}', name: self::ROUTE_NAME, methods: [Request::METHOD_GET])]
    #[ParamConverter('company', options: ['mapping' => ['siren' => 'siren']])]
    public function __invoke(SerializerInterface $serializer, Company $company, Request $request)
    {
        $response = new Response($serializer->serialize($company, 'json'));

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}