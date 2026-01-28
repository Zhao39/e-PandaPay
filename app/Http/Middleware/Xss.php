<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;
use Symfony\Component\HttpFoundation\Response;

class Xss
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $input = $request->all();

        array_walk_recursive($input, function (&$input) {
            $input = is_null($input) ? null : Purifier::clean(html_entity_decode($input));
        });

        $request->merge($input);

        $input = $request->all();
        array_walk_recursive($input, function (&$input) {
            $input = is_null($input) ? null : str_replace('&amp;', '&', $input);
        });
        $request->merge($input);

        return $next($request);
    }
}
