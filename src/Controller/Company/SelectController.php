<?php

namespace App\Controller\Company;

use App\Controller\API\CompanyAPI;
use App\Form\Company\SearchType;
use App\Services\CompanyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


class SelectController extends AbstractController
{
    const ROUTE_NAME = 'company_select';

    #[Route('/entreprise/selectionner/{siren}', name: self::ROUTE_NAME, methods: [Request::METHOD_GET])]
    public function __invoke(Request $request, CompanyService $companyService, CompanyAPI $companyAPI, string $siren): Response
    {
        $company = $companyAPI->findBySiren($siren);

        if ($company === null) {
            throw new NotFoundHttpException();
        }

        $companyService->save($company);

        return $this->render('pages/company/select.html.twig', [
            'company' => $company
        ]);
    }
}