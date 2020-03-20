<?php

namespace Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;
use App\Services\ResultsService;
use Illuminate\Support\Collection;
use App\Contracts\ResultsRepositoryContract;
use App\Contracts\ResultsApiRepositoryContract;
use App\Models\Results;
use stdClass;

class ResultsServiceTest extends TestCase
{

    private ResultsService $resultsService;
    private ResultsRepositoryContract $resultsRepositoryMock;
    private ResultsApiRepositoryContract $resultsApiRepositoryMock;

    public function setUp(): void
    {
        $json = json_decode(file_get_contents(__DIR__ . '/sample_data.json'));

        $this->resultsRepositoryMock = Mockery::mock(ResultsRepositoryContract::class)
            ->shouldReceive([
                'storeResult' => null,
                'findById' => new Results(),
                'updateResult' => new Results(),
                'getResultsWithOrdering' => new Collection()
            ])
            ->getMock();

        $this->resultsApiRepositoryMock = Mockery::mock(ResultsApiRepositoryContract::class)
            ->shouldReceive([
                'get' => new Collection($json)
            ])
            ->getMock();

        parent::setUp();
    }

    public function test_can_use_fetchDataFromResultsApi(): void
    {
        $this->resultsService = new ResultsService($this->resultsRepositoryMock, $this->resultsApiRepositoryMock);
        $this->assertTrue($this->resultsService->fetchDataFromResultsApi());
    }

    public function test_can_use_fetchDataFromResultsApi_on_new_data(): void
    {
        $resultsRepositoryMock = Mockery::mock(ResultsRepositoryContract::class)
            ->shouldReceive([
                'storeResult' => null,
                'findById' => null,
                'storeResult' => null
            ])
            ->getMock();

        $resultsService = new ResultsService($resultsRepositoryMock, $this->resultsApiRepositoryMock);

        $this->assertTrue($resultsService->fetchDataFromResultsApi());
    }

    public function test_can_use_getResultsWithOrdering(): void
    {
        $this->resultsService = new ResultsService($this->resultsRepositoryMock, $this->resultsApiRepositoryMock);
        $this->assertInstanceOf(Collection::class, $this->resultsService->getResultsWithOrdering('score'));
    }
}
