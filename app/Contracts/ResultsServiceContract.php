<?php

namespace App\Contracts;

interface ResultsServiceContract
{
    public function fetchDataFromResultsApi(): bool;
}