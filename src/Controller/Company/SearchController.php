<?php

namespace App\Controller\Company;

use App\Controller\API\CompanyAPI;
use App\Form\Company\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SearchController extends AbstractController
{
    const ROUTE_NAME = 'company_search';

    #[Route('/entreprise/recherche', name: self::ROUTE_NAME, methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function __invoke(Request $request, CompanyAPI $companyAPI): Response
    {
        $companies = [];
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $companies = $companyAPI->search($form->getData()['q'])['results'];
        }

        return $this->render('pages/company/search.html.twig', [
            'form' => $form,
            'companies' => $companies
        ]);
    }
}