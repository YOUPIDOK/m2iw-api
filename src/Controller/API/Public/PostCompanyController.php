<?php

namespace App\Controller\API\Public;

use App\DTO\CompanyDTO;
use App\Entity\Company;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PostCompanyController extends AbstractController
{
    const ROUTE_NAME = 'api_open_post_company';

    #[Route('/api-ouverte-ent', name: self::ROUTE_NAME, methods: [Request::METHOD_POST])]
    public function __invoke(
        SerializerInterface $serializer,
        Request $request,
        RouterInterface $router,
        ValidatorInterface $validator,
        CompanyRepository $companyRepository,
        EntityManagerInterface $em
    ) {
        $companyJson = $request->getContent();
        $companyDTO = $serializer->deserialize($companyJson, CompanyDTO::class, 'json');
        $errors = $validator->validate($companyDTO);

        if (count($errors) > 0) {
            return new JsonResponse(['errors' => (string) $errors], 400);
        }

        if ($companyRepository->findOneBy(['siren' => $companyDTO->getSiren()]) !== null) {
            throw new ConflictHttpException("Cette entreprise existe déjà.");
        }

        $company = $companyDTO->toCompany();
        $em->persist($company);
        $em->flush();

        $url = $router->generate(GetCompanyController::ROUTE_NAME, [
            'siren' => $company->getSiren()
        ],RouterInterface::ABSOLUTE_URL);

        return new JsonResponse(['entreprise' => $url], 201);
    }
}