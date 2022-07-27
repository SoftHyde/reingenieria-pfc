<?php

// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Contracts\Auth\Guard;

// class Authenticate
// {
//     /**
//      * The Guard implementation.
//      *
//      * @var Guard
//      */
//     protected $auth;

//     /**
//      * Create a new middleware instance.
//      *
//      * @param  Guard  $auth
//      * @return void
//      */
//     public function __construct(Guard $auth)
//     //public function __construct($request,array $guards)
//     {
//         $this->auth = $auth;
//     }

//     /**
//      * Handle an incoming request.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @param  \Closure  $next
//      * @return mixed
//      */
//     public function handle($request, Closure $next)
//     {
//         if ($this->auth->guest()) {
//             if ($request->ajax()) {
//                 return response('Unauthorized.', 401);
//             } else {
//                 return redirect()->guest(route('login'));
//             }
//         }

//         return $next($request);
//     }
// }
namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}