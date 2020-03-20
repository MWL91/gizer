<?php
namespace App\Contracts;

use App\Dto\ResultDto;
use App\Models\Results;
use Ramsey\Uuid\UuidInterface;
use Illuminate\Support\Collection;

interface ResultsRepositoryContract
{
    public function storeResult(ResultDto $resultDto): void;

    public function getResultsWithOrdering(string $orderBy, string $order): Collection;

    public function findById(UuidInterface $id): ?Results;

    public function updateResult(Results $result, ResultDto $resultDto): Results;
}