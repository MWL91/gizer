<?php
namespace App\Http\ResponseStrategies;

use InvalidArgumentException;
use App\Http\ResponseStrategies\ResponseStrategyInterface;

trait ResponsesStrategy
{

    public function getResponseClass(string $dataType): ResponseStrategyInterface
    {
        $className = 'App\\Http\\ResponseStrategies\\'. ucfirst($dataType) . 'Response';

        if(!class_exists($className)) {
            throw new InvalidArgumentException("Response class $className dose not exists.");
        }

        return new $className;
    }

    public function getDefaultResponseClass(): ResponseStrategyInterface
    {
        $dataType = config('api.response.default', 'json');
        return $this->getResponseClass($dataType);
    }

}