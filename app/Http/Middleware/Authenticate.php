<?php namespace Ecep\Http\Middleware;

use Closure;
use Ecep\Helpers\HelperApp;
use Illuminate\Contracts\Auth\Guard;

class Authenticate
{

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
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
        if (!$request->session()->has('user')) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect(HelperApp::baseUrl('auth/login'));
            }
        }

        return $next($request);
    }

}
