<?php

namespace App\Repositories\Rest;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use App\Contracts\ResultsApiRepositoryContract;
use RuntimeException;

class ResultsApiRepository implements ResultsApiRepositoryContract
{
    protected string $apiUrl;
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->apiUrl = config('api.url.results');
        $this->client = $client;
    }

    public function get(int $page = 1): Collection
    {
        $response = $this->client->request('GET', $this->apiUrl . $page);
        if ($response->getStatusCode() != 200) {
            throw new RuntimeException("Results api response with code " . $response->getStatusCode());
        }

        $data = json_decode($response->getBody()->getContents());
        if(!$data) {
            throw new RuntimeException("Datas recived from api is not correct");
        }
        
        return new Collection($data);
    }
}
