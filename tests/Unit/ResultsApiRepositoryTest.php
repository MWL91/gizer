<?php

namespace Tests\Unit;

use Tests\TestCase;
use RuntimeException;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Exception\RequestException;
use App\Repositories\Rest\ResultsApiRepository;

class ResultsApiRepositoryTest extends TestCase
{

    public function test_can_use_get(): void
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . '/sample_data.json')),
        ]);
        
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $resultsApiRepository = new ResultsApiRepository($client);
        $this->assertInstanceOf(Collection::class, $resultsApiRepository->get());
    }

    public function test_bad_response_exception_using_get(): void
    {
        $mock = new MockHandler([
            new RequestException('Error Communicating with Server', new Request('GET', 'api/score')),
        ]);
        
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $resultsApiRepository = new ResultsApiRepository($client);
        $this->expectException(RequestException::class);
        $resultsApiRepository->get();
    }

    public function test_bad_data_exception_using_get(): void
    {
        $mock = new MockHandler([
            new Response(200, [], '<html><body>This is not JSON!</body></html>'),
        ]);
        
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $resultsApiRepository = new ResultsApiRepository($client);
        $this->expectException(RuntimeException::class);
        $resultsApiRepository->get();
    }
}
