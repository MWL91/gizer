<?php

namespace Tests\Integration;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class ResultsControllerTest extends TestCase
{

    public function test_can_get_data_from_api()
    {
        $response = $this->json('get', 'api/results');

        $response->assertStatus(200);
    }

    public function test_can_get_data_from_api_ordered_asc_by_score()
    {
        $response = $this->json('get', 'api/results', [
            'order' => 'asc',
            'order_by' => 'score',
        ]);

        $decodedResponse = $response->decodeResponseJson();
        $firstScore = $decodedResponse[0];
        $lastScore = end($decodedResponse);

        $response->assertStatus(200);
        $this->assertTrue($firstScore['score'] <= $lastScore['score']);
    }

    public function test_can_get_data_from_api_ordered_desc_by_finished_at()
    {
        $response = $this->json('get', 'api/results', [
            'order' => 'desc',
            'order_by' => 'finished_at',
        ]);

        $decodedResponse = $response->decodeResponseJson();
        $firstScore = $decodedResponse[0];
        $lastScore = end($decodedResponse);

        $response->assertStatus(200);
        $this->assertTrue($firstScore['finished_at'] >= $lastScore['finished_at']);
    }

    public function test_can_get_data_from_api_with_fetch()
    {
        Config::set('api.fetch.always', true);

        $response = $this->json('get', 'api/results', [
            'order' => 'desc',
            'order_by' => 'finished_at',
        ]);

        $decodedResponse = $response->decodeResponseJson();
        $firstScore = $decodedResponse[0];
        $lastScore = end($decodedResponse);

        $response->assertStatus(200);
        $this->assertTrue($firstScore['finished_at'] >= $lastScore['finished_at']);
    }
}
