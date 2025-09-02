<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class AttachCorrelationId
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id = $request->header('X-Correlation-Id') ?? (string) Str::uuid();

        //Associate with global context logs
        Log::withContext([
            'correlation_id' => $id,
            'ip' => $request->ip(),
        ]);

        //But also attach to a request for controllers/services etc. to use
        $request->attributes->set('correlation_id', $id);

        return $next($request);
    }
}
