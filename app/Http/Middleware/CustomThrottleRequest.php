<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponser;
use Closure;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Symfony\Component\HttpFoundation\Response;

class CustomThrottleRequest extends ThrottleRequests
{
    use ApiResponser;
    /**
     * TODO middleware que retorna la respuesta cuando se excede en las peticiones de cada servicio
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @return mixed|Response
     */
    protected function buildResponse($key, $maxAttempts)
    {
        $response = $this->errorResponse('Too Many Attempts.', 429);

        $retryAfter = $this->limiter->availableIn($key);

        return $this->addHeaders(
            $response, $maxAttempts,
            $this->calculateRemainingAttempts($key, $maxAttempts, $retryAfter),
            $retryAfter
        );
    }
}
