<?php

namespace Tests\Integration;

use Tests\TestCase;
use App\Services\ResultsService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Contracts\ResultsServiceContract;
use App\Contracts\ResultsApiRepositoryContract;

class ResultsServiceTest extends TestCase
{
    public function test_can_fetch_data_from_api_repository()
    {
        // Testing on Laravel app helper only for integration issues
        $resultsApiRepository = app(ResultsApiRepositoryContract::class);
        
        $this->assertInstanceOf(Collection::class, $resultsApiRepository->get());
    }

    public function test_can_fetch_data_using_service()
    {
        DB::collection('results')->delete();
        
        // Testing on Laravel app helper only for integration issues
        $resultsService = app(ResultsServiceContract::class);
        
        $this->assertTrue($resultsService->fetchDataFromResultsApi());

        $this->assertDatabaseHas('results', [
            'id' => 'a227380b-890b-4265-b26a-d5c8849c281a'
        ]);
    }

    public function test_can__get_data_by_date_using_service()
    {
        
    }
}
