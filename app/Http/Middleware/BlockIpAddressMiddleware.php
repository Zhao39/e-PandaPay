<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlockIpAddressMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $ipaddress = DB::table('i_p_addresses')->pluck('address');
        $iparrays = $ipaddress->toArray();
        $userip = $request->ip();
        if (in_array($userip, $iparrays)) {
            abort(403, 'You are restricted to access the site.');
        }
        return $next($request);
    }
}
