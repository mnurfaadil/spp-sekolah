<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CekStatus
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
        if (Auth::user()->role=="Yayasan") {
            return redirect()
                ->route('rekap.index')
                ->with('error','Akses Ditolak!');
        }
        return $next($request);
    }
}
