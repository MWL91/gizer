<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\GetResultsRequest;
use App\Contracts\ResultsServiceContract;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\HttpFoundation\Response;
use App\Http\ResponseStrategies\ResponsesStrategy;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ResultsController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ResponsesStrategy;

    private ResultsServiceContract $resultsService;

    public function __construct(ResultsServiceContract $resultsService)
    {
        $this->resultsService = $resultsService;
    }

    /**
     * Get Results Endpoint
     * 
     * @OA\Get(
     *      path="/api/results",
     *      operationId="getResults",
     *      summary="Get results",
     *      @OA\Response(
     *          response=200,
     *          description="Get results data",
     *          @OA\MediaType(mediaType="application/json")
     *      ),
     *      @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *          @OA\MediaType(mediaType="application/json")
     *      )
     * )
     *
     * @param GetResultsRequest $request
     * @return Response
     */
    public function getResults(GetResultsRequest $request): Response
    {
        // $request
        $data = [];

        $response = $this->getDefaultResponseClass();
        $response->setData($data);
        $response->setStatus(200);

        return $response->getResponse();
    }

}
