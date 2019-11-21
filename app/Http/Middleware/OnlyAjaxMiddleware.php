<?php

namespace App\Http\Middleware;

use Closure;

class OnlyAjaxMiddleware
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
        if(!$request->ajax()){
            // return response('Forbidden', 403)->json(['status' => 'error', 'title' => 'Gagal!', 'msg' => 'Request tidak berupa ajax']);
            return response('Forbidden', 403);
        }

        return $next($request);
    }
}
