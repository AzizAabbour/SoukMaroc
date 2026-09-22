<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsSeller
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || (!$request->user()->isSeller() && !$request->user()->isAdmin())) {
            return response()->json([
                'message' => 'Unauthorized. Seller access required.'
            ], 403);
        }

        return $next($request);
    }
}
