<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface ResultsServiceContract
{
    public function fetchDataFromResultsApi(): bool;

    public function getResultsWithOrdering(string $orderBy, string $order = 'desc'): Collection;
}