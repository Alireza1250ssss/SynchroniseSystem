<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateWebService
{
    /**
     * his middleware is used to authenticate third-party systems
     * to access our endpoints
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // authorize the request for example : based on a header containing a access token
        return $next($request);
    }
}
