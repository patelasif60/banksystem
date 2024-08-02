<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;


class TwoFactor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        // print_r(now());
        // dd($user);
        if(auth()->check() && $user->two_factor_code)
        {
            if($user->two_factor_expires_at < now()) //expired
            {
                $user->timestamps = false;
                $user->two_factor_code = null;
                $user->two_factor_expires_at = null;
                $user->save();
                auth()->logout();
                return redirect()->route('login')
                ->withMessage('The two factor code has expired. Please login again.');
            }

            if(!$request->is('verify*')) //prevent enless loop, otherwise send to verify
            {
                return redirect()->route('verify');
            }
        }

        return $next($request);
    }
}
