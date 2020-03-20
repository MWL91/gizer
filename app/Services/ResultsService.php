<?php

namespace App\Services;

use RuntimeException;
use App\Dto\ResultDto;
use Illuminate\Support\Collection;
use App\Contracts\ResultsServiceContract;
use GuzzleHttp\Exception\ClientException;
use App\Contracts\ResultsRepositoryContract;
use App\Contracts\ResultsApiRepositoryContract;

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
     * @throws ClientException
     * @return boolean
     */
    public function fetchDataFromResultsApi(): bool
    {
        $results = $this->resultsApiRepository->get();
            
        foreach($results as $result)
        {
            $resultDto = new ResultDto($result);
            $result = $this->resultsRepository->findById($resultDto->getId());
            if($result) {
                $this->resultsRepository->updateResult($result, $resultDto);
            } else {
                $this->resultsRepository->storeResult($resultDto);
            }
        }

        return true;
    }

    /**
     * Get results ordered by finished_at
     *
     * @param string $order
     * @return Collection
     */
    public function getResultsWithOrdering(string $orderBy, string $order = 'desc'): Collection
    {
        return $this->resultsRepository->getResultsWithOrdering($orderBy, $order);
    }

}