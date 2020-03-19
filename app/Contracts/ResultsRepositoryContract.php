<?php
namespace App\Contracts;

use App\Dto\ResultDto;
use Illuminate\Support\Collection;

interface ResultsRepositoryContract
{
    public function storeResult(ResultDto $resultDto): void;

    public function getResultsOrderedByDate(string $order): Collection;

    public function getResultsOrderedByScore(string $order): Collection;
}