<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Requests\GetResultsRequest;
use App\Contracts\ResultsServiceContract;
use App\Http\Middleware\ResultsMiddleware;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\HttpFoundation\Response;
use App\Http\ResponseStrategies\ResponsesStrategy;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

final class ResultsController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ResponsesStrategy;

    private ResultsServiceContract $resultsService;

    public function __construct(ResultsServiceContract $resultsService)
    {
        $this->resultsService = $resultsService;
        $this->middleware([ResultsMiddleware::class]);
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
        $response = $this->getDefaultResponseClass();

        try {
            $data = $this->resultsService->getResultsWithOrdering(
                $request->get('order_by', 'score'),
                $request->get('order', 'desc')
            )->toArray();

            $response->setData($data);
            $response->setStatus(200);
        } catch (Exception $e) {
            $response->setData([
                'message' => $e->getMessage()
            ]);
            $response->setStatus(400);
        }

        return $response->getResponse();
    }
}
