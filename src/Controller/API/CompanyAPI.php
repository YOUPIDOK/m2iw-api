<?php

namespace App\Controller\API;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CompanyAPI
{
    const BASE_URI = 'https://recherche-entreprises.api.gouv.fr/';

    public function __construct(private HttpClientInterface $client) { }

    public function search(string $q, int $page = 1): array
    {
        $res = $this->client->request(Request::METHOD_GET, self::BASE_URI . 'search', [
            'query' => [
                'q' => $q,
                'page' => $page
            ]
        ]);

        return $res->toArray();
    }
}