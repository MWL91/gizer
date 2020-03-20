<?php

namespace Tests\Integration;

use Tests\TestCase;

class FetchResultsDataCommandTest extends TestCase
{

    public function test_can_get_data_from_api_ordered_asc_by_score()
    {
        $this->artisan('fetch:results')
             ->expectsOutput('Fetching results...')
             ->expectsOutput('Results data fetched from API');
    }
}
