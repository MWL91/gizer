<?php

namespace App\Services;

use Exception;
use App\Contracts\ResultsServiceContract;
use GuzzleHttp\Exception\ClientException;
use App\Contracts\ResultsRepositoryContract;
use App\Contracts\ResultsApiRepositoryContract;
use App\Dto\ResultDto;

class ResultsService implements ResultsServiceContract
{

    private ResultsRepositoryContract $resultsRepository;
    private ResultsApiRepositoryContract $resultsApiRepository;

    public function __construct(
        ResultsRepositoryContract $resultsRepository, 
        ResultsApiRepositoryContract $resultsApiRepository
    ) {
        $this->resultsRepository = $resultsRepository;
        $this->resultsApiRepository = $resultsApiRepository;
    }

    public function fetchDataFromResultsApi(): bool
    {
        try {
            $results = $this->resultsApiRepository->get();

            foreach($results as $result)
            {
                $result = new ResultDto($result);
                $this->resultsRepository->storeResult($result);
            }

            
        } catch (ClientException $e) {
            dd($e); //TODO: HANDLE API EXCEPTION
        } catch (Exception $e) {
            dd($e); //TODO: HANDLE STANDARD EXCEPTION
        }

        return true;
    }

}