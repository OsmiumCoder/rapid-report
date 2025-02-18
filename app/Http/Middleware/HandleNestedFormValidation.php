<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Symfony\Component\HttpFoundation\Response;

class HandleNestedFormValidation extends Middleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $failedRules = [];

//        dd($response->toArray());
//        foreach ($response->exception->validator->failedRules as $field => $rules) {
//            dd($rules);
//        }

        return $response;
    }
}
