<?php

namespace Tests\Integration;

use Tests\TestCase;
use App\Services\ResultsService;
use App\Contracts\ResultsApiRepositoryContract;
use App\Contracts\ResultsServiceContract;
use Illuminate\Support\Collection;

class ResultsServiceTest extends TestCase
{
    public function test_can_fetch_data_from_api_repository()
    {
        // Testing on Laravel app helper only for integration issues
        $resultsApiRepository = app(ResultsApiRepositoryContract::class);
        
        $this->assertInstanceOf(Collection::class, $resultsApiRepository->get());
    }

    public function test_can_fetch_data_inside_service()
    {
        // Testing on Laravel app helper only for integration issues
        $resultsService = app(ResultsServiceContract::class);
        
        $this->assertTrue($resultsService->fetchDataFromResultsApi());
    }
}
