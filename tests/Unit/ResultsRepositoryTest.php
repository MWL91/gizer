<?php

namespace Tests\Unit;

use Mockery;
use Carbon\Carbon;
use App\Dto\UserDto;
use Ramsey\Uuid\Uuid;
use App\Dto\ResultDto;
use App\Models\Results;
use Ramsey\Uuid\UuidInterface;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Collection;
use App\Contracts\ResultsRepositoryContract;
use App\Repositories\Mongo\ResultsRepository;
use App\Contracts\ResultsApiRepositoryContract;

class ResultsRepositoryTest extends TestCase
{

    private Results $resultsMock;
    private ResultsRepositoryContract $resultsRepositoryMock;
    private ResultsApiRepositoryContract $resultsApiRepositoryMock;

    public function test_can_use_fetchDataFromResultsApi(): void
    {
        $mockFirst = Mockery::mock(Results::class)
            ->shouldReceive([
                'first' => new Results
            ])
            ->getMock();

        $resultsMock = Mockery::mock(Results::class)
            ->shouldReceive([
                'where' => $mockFirst
            ])
            ->getMock();

        $resultsRepository = new ResultsRepository($resultsMock);
        $uuid = Uuid::uuid4();

        $this->assertInstanceOf(Results::class, $resultsRepository->findById($uuid));
    }

    public function test_can_use_storeResult(): void
    {
        $json = json_decode(file_get_contents(__DIR__ . '/sample_data.json'));
        $resultsDto = new ResultDto($json[0]);

        $resultsMock = Mockery::mock(Results::class)
            ->shouldReceive([
                'create' => new Results
            ])
            ->getMock();

        $resultsRepository = new ResultsRepository($resultsMock);
        $uuid = Uuid::uuid4();

        $this->assertNull($resultsRepository->storeResult($resultsDto));

        $this->assertInstanceOf(UuidInterface::class, $resultsDto->getId());
        $this->assertEquals(new UserDto($json[0]->user), $resultsDto->getUser());
        $this->assertEquals($json[0]->score, $resultsDto->getScore());
        $this->assertEquals(new Carbon($json[0]->finished_at), $resultsDto->getFinishedAt());

        $this->assertInstanceOf(UuidInterface::class, $resultsDto->getUser()->getId());
        $this->assertEquals($json[0]->user->name, $resultsDto->getUser()->getName());
    }

    public function test_can_use_updateResult(): void
    {
        $json = json_decode(file_get_contents(__DIR__ . '/sample_data.json'));
        $resultsDto = new ResultDto($json[0]);

        $resultsMock = Mockery::mock(Results::class)
            ->shouldReceive([
                'update' => true
            ])
            ->getMock();

        $resultsRepository = new ResultsRepository($resultsMock);
        $uuid = Uuid::uuid4();

        $this->assertInstanceOf(Results::class, $resultsRepository->updateResult($resultsMock, $resultsDto));
    }

    public function test_can_use_getResultsWithOrdering(): void
    {
        $mockGet = Mockery::mock(Results::class)
            ->shouldReceive([
                'get' => new Collection()
            ])
            ->getMock();

        $resultsMock = Mockery::mock(Results::class)
            ->shouldReceive([
                'orderBy' => $mockGet
            ])
            ->getMock();

        $resultsRepository = new ResultsRepository($resultsMock);

        $this->assertInstanceOf(Collection::class, $resultsRepository->getResultsWithOrdering('score', 'desc'));
    }
}
