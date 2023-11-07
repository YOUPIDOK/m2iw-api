<?php

namespace App\Controller\API;

use App\DTO\Company;
use App\DTO\UrsaffApi\MinSalaryInternship;
use App\DTO\UrsaffApi\NetSalaryAlternance;
use App\DTO\UrsaffApi\NetSalaryCDD;
use App\DTO\UrsaffApi\NetSalaryCDI;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UrssafApi
{
    const BASE_URI = 'https://mon-entreprise.urssaf.fr/api/v1/';

    public function __construct(private HttpClientInterface $client, private NormalizerInterface $serializer) { }

    public function netSalaryCDI(int $salary, Company $company): NetSalaryCDI
    {
        $res = $this->client->request(Request::METHOD_POST, self::BASE_URI . 'evaluate', [
           'json' => [
               "situation" => [
                   "salarié . contrat . salaire brut" => [
                       "valeur" => $salary,
                       "unité" => "€ / mois"
                   ],
                   "salarié . contrat . CDI" => "oui",
                   "entreprise . SIREN" => $company->getSiren()
               ],
               "expressions" => [
                   "salarié . rémunération . net . à payer avant impôt",
                   "salarié . cotisations . salarié",
                   "salarié . coût total employeur"
               ]
           ]
        ]);

        $res = $res->toArray();

        return new NetSalaryCDI($res['evaluate'][0]['nodeValue'], $res['evaluate'][1]['nodeValue'], $res['evaluate'][2]['nodeValue']);
    }

    public function minSalaryInternship(Company $company): MinSalaryInternship
    {
        $res = $this->client->request(Request::METHOD_POST, self::BASE_URI . 'evaluate', [
            'json' => [
                "situation" => [
                    "salarié . contrat . stage" => 'oui',
                    "entreprise . SIREN" => $company->getSiren()
                ],
                "expressions" => [
                    "salarié . contrat . stage . gratification minimale",
                ]
            ]
        ]);

        $res = $res->toArray();

        return new MinSalaryInternship($res['evaluate'][0]['nodeValue']);
    }

    public function netSalaryCDD(int $salary, Company $company): NetSalaryCDD
    {
        $res = $this->client->request(Request::METHOD_POST, self::BASE_URI . 'evaluate', [
            'json' => [
                "situation" => [
                    "salarié . contrat . salaire brut" => [
                        "valeur" => $salary,
                        "unité" => "€ / mois"
                    ],
                    "salarié . contrat . CDD" => "oui",
                    "entreprise . SIREN" => $company->getSiren()
                ],
                "expressions" => [
                    "salarié . rémunération . net . à payer avant impôt",
                    "salarié . cotisations . salarié",
                    "salarié . coût total employeur",
                    "salarié . rémunération . indemnités CDD . fin de contrat"
                ]
            ]
        ]);

        $res = $res->toArray();

        return new NetSalaryCDD($res['evaluate'][0]['nodeValue'], $res['evaluate'][1]['nodeValue'], $res['evaluate'][2]['nodeValue'],  $res['evaluate'][3]['nodeValue']);
    }

    public function netSalaryAlternance(int $salary, Company $company): NetSalaryAlternance
    {
        $res = $this->client->request(Request::METHOD_POST, self::BASE_URI . 'evaluate', [
            'json' => [
                "situation" => [
                    "salarié . contrat . salaire brut" => [
                        "valeur" => $salary,
                        "unité" => "€ / mois"
                    ],
                    "salarié . contrat . apprentissage" => "oui",
                    "entreprise . SIREN" => $company->getSiren()
                ],
                "expressions" => [
                    "salarié . rémunération . net . à payer avant impôt",
                    "salarié . cotisations . salarié",
                    "salarié . coût total employeur",
                ]
            ]
        ]);

        $res = $res->toArray();

        return new NetSalaryAlternance($res['evaluate'][0]['nodeValue'], $res['evaluate'][1]['nodeValue'], $res['evaluate'][2]['nodeValue']);
    }
}