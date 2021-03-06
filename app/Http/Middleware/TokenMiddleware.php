<?php

namespace App\Http\Middleware;

use Closure;

class TokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //$fileUploadObj = $request->input('formData');
        if (!$request->input('token') )//or !$fileUploadObj['token'])
        {
            return response('no token', 500);
        }

        return $next($request);
    }
}
