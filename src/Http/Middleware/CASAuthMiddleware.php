<?php

namespace CSI_UKSW\Laravel\CAS\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class CASAuthMiddleware
{
    protected $auth;
    protected $cas;

    /**
     * Init CASAuthMiddleware
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->cas = app('cas');
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            return $next($request);
        } // Redirect to link after login
        else {
            if (Auth::attempt(array())) {
                return $next($request);
            }
            $this->cas->authenticate();
        }

        return $next($request);
    }
}
