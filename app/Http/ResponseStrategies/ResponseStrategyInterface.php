<?php
namespace App\Http\ResponseStrategies;

use Symfony\Component\HttpFoundation\Response;

interface ResponseStrategyInterface
{

    public function setData(array $data): void;
    public function setStatus(int $status): void;
    public function getResponse(): Response;

} 