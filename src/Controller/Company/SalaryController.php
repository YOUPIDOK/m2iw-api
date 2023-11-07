<?php

namespace App\Controller\Company;

use App\API\UrssafApi;
use App\Form\Company\SalaryType;
use App\Services\CompanyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SalaryController extends AbstractController
{
    const ROUTE_NAME = 'company_salary';

    #[Route('/entreprise/salaire', name: self::ROUTE_NAME, methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function __invoke(Request $request, CompanyService $companyService, UrssafApi $urssafApi): Response
    {
        $netSalaryCDI = null;
        $netSalaryCDD = null;
        $netSalaryAlternance = null;
        $minSalaryInternship = null;
        $company = $companyService->getCompany();
        $isSubmitted = false;

        if ($company === null) {
            return $this->redirectToRoute(SearchController::ROUTE_NAME);
        }

        $form = $this->createForm(SalaryType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $salary = $form->getData()['salary'];
            $netSalaryCDI = $urssafApi->netSalaryCDI($salary, $company);
            $minSalaryInternship = $urssafApi->minSalaryInternship($company);
            $netSalaryCDD = $urssafApi->netSalaryCDD($salary, $company);
            $netSalaryAlternance = $urssafApi->netSalaryAlternance($salary, $company);
            $isSubmitted = true;
        }

        return $this->render('pages/company/salary.html.twig', [
            'company' => $company,
            'netSalaryCDI' => $netSalaryCDI,
            'netSalaryCDD' => $netSalaryCDD,
            'netSalaryAlternance' => $netSalaryAlternance,
            'minSalaryInternship' => $minSalaryInternship,
            'form' => $form,
            'isSubmitted' => $isSubmitted
        ]);
    }
}