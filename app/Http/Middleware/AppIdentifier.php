<?php

namespace App\Http\Middleware;

use App\Models\Apikey;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AppIdentifier
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $appIdentifier = $request->header('identifier');
        $appIdentifier = Apikey::where('key', $appIdentifier)->first();
        if (!$appIdentifier) {
            return response()->json(['success'=> false, 'error' => 'Invalid App Identifier'], 401);
        }

        $user = Auth::guard('sanctum')->user();
        return $next($request);
    }
}
