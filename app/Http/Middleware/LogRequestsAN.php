<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogRequestsAN
{
    public function handle(Request $request, Closure $next)
    {
        Log::info('Task app request', [
            'method' => $request->method(),
            'path' => $request->path(),
            'user_id' => optional($request->user())->id,
        ]);

        return $next($request);
    }
}
