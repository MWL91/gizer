<?php
namespace App\Contracts;

use Illuminate\Support\Collection;

interface ResultsApiRepositoryContract
{
    public function get(int $page = 1): Collection;
}