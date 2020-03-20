<?php
namespace App\Http\ResponseStrategies;

use Illuminate\Http\JsonResponse as Response;
use App\Http\ResponseStrategies\ResponseStrategyInterface;

class JsonResponse implements ResponseStrategyInterface
{

    private ?array $data = null;
    private int $status = 200;

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function getResponse(): Response
    {
        return new Response($this->data, $this->status);
    }

}