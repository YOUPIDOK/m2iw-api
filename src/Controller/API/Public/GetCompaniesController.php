<?php

namespace App\Controller\API\Public;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GetCompaniesController extends AbstractController
{
    const ROUTE_NAME = 'api_open_get_companies';

    #[Route('/api-ouverte-ent-liste', name: self::ROUTE_NAME, methods: [Request::METHOD_GET])]
    public function __invoke(SerializerInterface $serializer, CompanyRepository $companyRepo, Request $request)
    {
        $format = $request->headers->get('Accept');

        if (!in_array($format, ['application/json', 'text/csv'])) {
            throw new NotAcceptableHttpException();
        }

        $companies = $companyRepo->findAll();

        $response = new Response($serializer->serialize($companies, match ($format){
            'application/json' => 'json',
            'text/csv' => 'csv'
        }));

        $response->headers->set('Content-Type', $format);
        return $response;
    }
}