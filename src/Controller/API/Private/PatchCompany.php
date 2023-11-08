<?php

namespace App\Controller\API\Private;

use App\Controller\API\Public\GetCompanyController;
use App\DTO\CompanyDTO;
use App\Entity\Company;
use App\Repository\CompanyRepository;
use App\Services\CompanyService;
use App\Services\ObjectMerger;
use Doctrine\ORM\EntityManagerInterface;
use ReflectionProperty;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PatchCompany extends AbstractController
{
    const ROUTE_NAME = 'api_open_patch_company';

    #[Route('/api-protege/{siren}', name: self::ROUTE_NAME, methods: [Request::METHOD_PATCH])]
    #[ParamConverter('company', options: ['mapping' => ['siren' => 'siren']])]
    public function __invoke(
        Company $company,
        EntityManagerInterface $em,
        Request $request,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        RouterInterface $router,
        CompanyRepository $companyRepository,
        ObjectMerger $merger,
    ) {
        if ($companyRepository->findOneBy(['siren' => $company->getSiren()]) === null) {
            throw new ConflictHttpException("Cette entreprise n'existe pas.");
        }

        $companyDTO = $company->toDTO() ;
        ObjectMerger::mergeData($companyDTO, json_decode($request->getContent(), true), [
            'id', 'siren'
        ]);

        $errors = $validator->validate($companyDTO);

        if (count($errors) > 0) {
            return new JsonResponse(['errors' => (string) $errors], 400);
        }

        $company = $companyDTO->toCompany($company);
        $em->flush();

        $url = $router->generate(GetCompanyController::ROUTE_NAME, [
            'siren' => $company->getSiren()
        ],RouterInterface::ABSOLUTE_URL);

        return new JsonResponse(['entreprise' => $url], 200);
    }
}