<?php

namespace Tests\Integration;

use Tests\TestCase;
use App\Models\Results;
use Illuminate\Support\Facades\DB;

class JsonToDatabaseTest extends TestCase
{
    public function test_can_add_json_to_database()
    {
        DB::collection('results')->delete();
        
        $json = json_decode(file_get_contents(__DIR__ . '/sample_data.json'));
        
        foreach($json as $record)
        {
            Results::create((array) $record);
        }

        // id can be the same we should not depend on this data 
        $this->assertDatabaseHas('results', [
            'id' => 'a227380b-890b-4265-b26a-d5c8849c281a'
        ]);
    }

    public function test_can_get_data_by_date()
    {
        $results = Results::orderBy('finished_at', 'desc')->pluck('finished_at');
        $this->assertTrue($results->first() >= $results->last());
    }

    public function test_can_get_data_by_score()
    {
        $results = Results::orderBy('score', 'desc')->pluck('score');
        $this->assertTrue($results->first() >= $results->last());
    }
}
