<?php

namespace App\Http\Middleware;

use App\Services\ReviewerService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class AddReviewerToken
{
    public function __construct(protected ReviewerService $reviewer) {}

    /**
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request)->cookie(
            Cookie::forever($this->reviewer->cookieKey(), $this->reviewer->getCurrentToken())
        );
    }
}
