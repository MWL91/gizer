<?php

namespace App\Console\Commands;

use App\Contracts\ResultsServiceContract;
use Exception;
use Illuminate\Console\Command;

class FetchResultsData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:results';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Results Data';

    private ResultsServiceContract $resultsService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ResultsServiceContract $resultsService)
    {
        $this->resultsService = $resultsService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Fetching results...');
        
        try {
            $this->resultsService->fetchDataFromResultsApi();
            $this->info('Results data fetched from API');
        } catch (Exception $e) {
            $this->error("There was error on fetch data: " . $e->getMessage());
        }
    }
}
