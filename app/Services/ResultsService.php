<?php

namespace App\Services;

use Exception;
use App\Dto\ResultDto;
use Illuminate\Support\Facades\Log;
use App\Contracts\ResultsServiceContract;
use GuzzleHttp\Exception\ClientException;
use App\Contracts\ResultsRepositoryContract;
use App\Contracts\ResultsApiRepositoryContract;
use Illuminate\Support\Collection;
use RuntimeException;

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

    /**
     * Fetch data from results API and store it after filter in db
     * 
     * This method also create Data Transfer Objects, for security reasons (for example duplicated ids) 
     * 
     * @throws RuntimeException
     * @return boolean
     */
    public function fetchDataFromResultsApi(): bool
    {
        try {
            $results = $this->resultsApiRepository->get();
            
            foreach($results as $result)
            {
                $resultDto = new ResultDto($result);
                $this->resultsRepository->storeResult($resultDto);
            }
        } catch (ClientException $e) {
            Log::info('There was a problem with connection to API');
            return false;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * Get results ordered by finished_at
     *
     * @param string $order
     * @return Collection
     */
    public function getResultsOrderedByDate(string $order = 'desc'): Collection
    {
        return $this->resultsRepository->getResultsOrderedByDate($order);
    }

    /**
     * Get results orderd by score
     *
     * @param string $order
     * @return Collection
     */
    public function getResultsOrderedByScore(string $order = 'desc'): Collection
    {
        return $this->resultsRepository->getResultsOrderedByScore($order);
    }

}