<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckApiKey
{
    public function handle(Request $request, Closure $next)
    {
        // Retrieve the API key from the request headers
        $apiKey = $request->header('X-API-KEY');

        // Check if the API key is valid (this can be stored in .env or database)
        $validApiKey = env('API_KEY'); // Assuming the valid API key is stored in the .env file

        if ($apiKey !== $validApiKey) {
            // If the API key is invalid, return an error response
            return response()->json(['error' => 'Unauthorized: Invalid API key'], 401);
        }

        // If the API key is valid, continue the request
        return $next($request);
    }
}
