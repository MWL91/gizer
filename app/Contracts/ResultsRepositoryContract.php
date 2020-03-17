<?php
namespace App\Contracts;

use App\Dto\ResultDto;

interface ResultsRepositoryContract
{
    public function storeResult(ResultDto $resultDto): void;
}