<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCompanyAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->company_id) {
            return response()->json(['message' => 'Unauthorized - No company access'], 401);
        }

        return $next($request);
    }
} 