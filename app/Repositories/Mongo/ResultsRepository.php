<?php
namespace App\Repositories\Mongo;

use App\Dto\ResultDto;
use App\Models\Results;
use Illuminate\Support\Collection;
use App\Contracts\ResultsRepositoryContract;

class ResultsRepository implements ResultsRepositoryContract
{

    private Results $model;

    public function __construct(Results $model)
    {
        $this->model = $model;
    }
    
    public function storeResult(ResultDto $resultDto): void
    {
        $this->model->create($resultDto->toArray());
    }

    public function getResultsOrderedByDate(string $order): Collection
    {
        return $this->model->orderBy('finished_at', $order)->get();
    }

    public function getResultsOrderedByScore(string $order): Collection
    {
        return $this->model->orderBy('score', $order)->get();
    }

}