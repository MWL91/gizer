<?php
namespace App\Repositories\Mongo;

use App\Dto\ResultDto;
use App\Models\Results;
use Illuminate\Support\Collection;
use App\Contracts\ResultsRepositoryContract;
use Ramsey\Uuid\UuidInterface;

class ResultsRepository implements ResultsRepositoryContract
{

    private Results $model;

    public function __construct(Results $model)
    {
        $this->model = $model;
    }

    public function findById(UuidInterface $id): ?Results
    {
        return $this->model->where('id', (string) $id)->first();
    }
    
    public function storeResult(ResultDto $resultDto): void
    {
        $this->model->create($resultDto->toArray());
    }

    public function updateResult(Results $result, ResultDto $resultDto): Results
    {
        $result->update($resultDto->toArray());

        return $result;
    }

    public function getResultsWithOrdering(string $orderBy, string $order): Collection
    {
        return $this->model->orderBy($orderBy, $order)->get();
    }

}