<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Level
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $privilege)
    {
        $userLevel = Auth::user()->level;
        if ($userLevel == 'admin') {
            return $next($request);
        } else if($userLevel == 'petugas' && ($privilege == 'petugas' || $privilege == 'anggota')){
            return $next($request);
        } else if($userLevel == 'anggota' && $privilege == 'anggota'){
            return $next($request);
        }

        return back();

    }
}
