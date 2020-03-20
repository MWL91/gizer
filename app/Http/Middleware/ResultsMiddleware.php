<?php

namespace App\Http\Middleware;

use App\Contracts\ResultsServiceContract;
use Closure;

class ResultsMiddleware
{
    private ResultsServiceContract $resultsService;

    public function __construct(ResultsServiceContract $resultsService)
    {
        $this->resultsService = $resultsService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(config('api.fetch.always')) {
            $this->resultsService->fetchDataFromResultsApi();
        }

        return $next($request);
    }
}
