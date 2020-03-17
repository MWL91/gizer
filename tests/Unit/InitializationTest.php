<?php

namespace Tests\Unit;

use App\Contracts\ResultsServiceContract;
use App\Services\ResultsService;
use PHPUnit\Framework\TestCase;

class InitializationTest extends TestCase
{
    /**
     * Results initialization test
     * 
     * @dataProvider instancesCollection
     *
     * @return void
     */
    public function testClassInitialization($instance, $abstract): void
    {
        $this->assertInstanceOf($abstract, $instance);
    }

    /**
     * Collection for validate if current DI are correct
     *
     * @return array
     */
    public function instancesCollection(): array
    {
        return [
            [
                new ResultsService(),
                ResultsServiceContract::class
            ]
        ];
    }
}
