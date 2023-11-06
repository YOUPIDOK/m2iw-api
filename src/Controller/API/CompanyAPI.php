<?php

namespace App\Controller\API;

use App\DTO\Address;
use App\DTO\Company;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CompanyAPI
{
    const BASE_URI = 'https://recherche-entreprises.api.gouv.fr/';

    public function __construct(private HttpClientInterface $client, private NormalizerInterface $serializer) { }

    public function search(string $q, int $page = 1): array
    {
        $res = $this->client->request(Request::METHOD_GET, self::BASE_URI . 'search', [
            'query' => [
                'q' => $q,
                'page' => $page
            ]
        ]);

        $res = $res->toArray();
        $res['results'] = $this->serializer->denormalize($res['results'], Company::class . '[]');

        return $res;
    }

    public function findBySiren(string $siren): ?Company
    {
        $res = $this->client->request(Request::METHOD_GET, self::BASE_URI . 'search', [
            'query' => [
                'q' => $siren,
            ]
        ]);

        $res = $res->toArray();
        $res= $this->serializer->denormalize($res['results'], Company::class . '[]');

        if (empty($res)) return null;

        return $res[0];
    }
}