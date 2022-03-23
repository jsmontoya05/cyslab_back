<?php

namespace App\Http\Middleware;

use Closure;

class CheckIpMiddleware
{
    public $whiteIps = ['127.0.0.1'];

    /**

     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     **
     **/
    public function handle($request, Closure $next)
    {   
        $setting = \App\Models\Setting::where('active',1)->first();
    
        $this->whiteIps = [$setting->ip_check_middleware];

        if (!in_array($request->ip(), $this->whiteIps)) {

            return response()->json(['your ip address is not valid.']);
        }

        return $next($request);
     }
}


